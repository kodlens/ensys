<template>

    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6-widescreen is-8-desktop is-10-tablet">

                    <div class="box">
                        <div class="has-text-weight-bold is-size-4">ADD/EDIT GROUP SUBJECT</div>
                        <div class="has-text-weight-bold mb-4 is-size-6">
                            Manage (add/edit) group subject per section.
                        </div>
                        <div class="has-text-weight-bold mb-4 info-header">GROUP SUBJECT INFORMATION</div>
                        
                        <div>
                            <!-- <div class="columns">
                                <div class="column">
                                    <b-field label="Academic Year" expanded>
                                        <b-select v-model="fields.academic_year_id" 
                                            expanded
                                            placeholder="Academic Year">
                                            <option v-for="(item, ix) in academicYears" :key="`ay${ix}`" 
                                                :value="item.academic_year_id">
                                                {{ item.academic_year_code }} - {{ item.academic_year_desc }}
                                            </option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div> -->
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Grade Level"
                                        expanded
                                        :type="errors.group_id ? 'is-danger':''"
                                        :message="errors.group_id ? errors.group_id[0] : ''" >
                                        <b-select
                                            expanded
                                            icon="account"
                                            placeholder="Grade Level"
                                            v-model="fields.group_id"
                                            required>
                                            <option :value="item.group_id"
                                                    v-for="(item, ix) in groups" :key="`g${ix}`">
                                                {{ item.group_name }}
                                            </option>
                                        </b-select >
                                    </b-field>
                                </div> <!--col--> 
                            </div> <!--cols-->
                        </div>

                        <hr>

                        <!-- <div class="has-text-weight-bold mb-4 info-header">SUBJECTS TO ENROLL</div> -->
                        <b-field
                            :type="this.errors.subjects ? 'is-danger':''"
                            :message="this.errors.subjects ? this.errors.subjects[0] : ''">
                        </b-field>
                        <!-- subjects loop -->
                        <div class="subject-card"
                            v-for="(item, index) in fields.subjects" :key="index">
                            
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Subjet Name" label-position="on-border">
                                        <b-input type="text" readonly v-model="item.subj_name" 
                                            placeholder="Subjet Name" /></b-field>
                                </div> <!--col--> 
                                <div class="column is-1">
                                    <b-button class="is-danger is-small is-outlined"
                                        icon-right="delete" @click="removeSubject(index)"></b-button>
                                </div>
                            </div> <!--cols-->
                        </div>
                        <div class="buttons is-right mt-4">
                            <modal-browse-button-subject
                                @browseSubject="emitBrowseSubject($event)"></modal-browse-button-subject>
                        </div>

                        <div class="has-text-weight-bold mb-4 info-header">CONTROLS/ACTION</div>

                        <div class="buttons mt-4 is-right">
                            <b-button class="is-primary has-text-weight-bold"
                                @click="submit"
                                label="SAVE GROUP SUBJECTS" icon-right="arrow-right"></b-button>
                        </div>
                        
                    </div> <!--panel-->
                </div> <!--col--> 
            </div> <!--cols-->
        </div>

    </div>
</template>

<script>

export default{
    data(){
        return {
            section_subjects: {},

            fields: {
                group_id: 0,
                subjects: []
            },
            errors: {},

            groups: [],
            semesters: [],


        }
    },

    methods: {

        emitBrowseSubject(row, ix){
            let flagFound = false
            this.fields.subjects.forEach(item => {
                if(item.subject_id === row.subject_id){
                    flagFound = true;
                }
            });
            
            if(flagFound){
                this.$buefy.toast.open({
                    message: 'Already added in the subject list.',
                    type: 'is-danger'
                })
                return;
            }

            this.fields.subjects.push({
                subject_id: row.subject_id,
                subject_code: row.subject_code,
                subject_description: row.subject_description,
                units: row.units,
                subj_name: row.subject_code + ' - ' + row.subject_description
            })

        },

        removeSubject(index){

            this.$buefy.dialog.confirm({
                title: 'DELETE?',
                message: 'Are you sure you want to remove this subject?',
                type: 'is-danger',

                onConfirm: ()=>{
                    let id = this.fields.subjects[index].enrol_subject_id;

                    if(id > 0){
                        axios.delete('/grade-level-subject-delete/' + id).then(res=>{
                            if(res.data.status === 'deleted'){
                                this.$buefy.toast.open({
                                    message: `Subject removed successfully.`,
                                    type: 'is-primary'
                                })
                            }
                        });
                    }

                    this.fields.subjects.splice(index, 1);
                }
            });
        },

        submit(){
            this.errors = {}
            axios.post('/group-subjects', this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: "Saved!",
                        message: 'Data successfully saved.',
                        type: 'is-success',
                        onConfirm: ()=>  window.location = '/group-subjects'
                    });
                }
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors

                    if(this.errors.message[0] === 'exist'){
                        this.$buefy.dialog.alert({
                            title: "Exist!",
                            message: 'Learner already admitted.',
                            type: 'is-danger'
                        });
                    }
                }
            })
        },



        loadGroups(){
            axios.get('/load-groups').then(res=>{
                this.groups = res.data;
            })
        },

        
        loadSemesters(){
            axios.get('/load-semesters').then(res=>{
                this.semesters = res.data;
            })
        }

    },

    mounted(){

        this.loadGroups()
        this.loadSemesters()

    }
}
</script>

<style scoped>

.info-header{
    background-color: #1f3596;
    padding: 10px;
    color: white;
}
.subject-card{
    margin: 10px 0px 5px 0px;
    border: 1px solid gray;
    padding: 15px;
}
</style>