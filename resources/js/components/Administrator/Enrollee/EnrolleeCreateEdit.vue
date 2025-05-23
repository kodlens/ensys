<template>
    <section class="section">
        <div class="columns is-centered">
            <div class="column is-8-widescreen is-8-desktop is-10-tablet">
                <form @submit.prevent="submit">

                    <div class="box">
                        <div class="box-title mb-2">
                            <div>UPDATE ENROLLMENT INFORMATION</div>
                            <div style="font-size: 16px; margin-bottom: 20px;">Update the learner enrollment information</div>
                        </div>

                        <div class="panel-body">
                                    
                            <div class="divider">LEARNER INFORMATION</div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Learner Status"
                                        :type="errors.learner_status ? 'is-danger':''"
                                        :message="errors.learner_status ? errors.learner_status[0] : ''" >
                                         <b-select expanded
                                            required
                                            icon="keyboard-return"
                                            placeholder="Learner Status"
                                            v-model="fields.learner_status">
                                            <option value="YES">YES</option>
                                            <option value="NO">NO</option>
                                        </b-select>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Returnee (Balik-Aral)"
                                        expanded
                                        :type="errors.balik_aral ? 'is-danger':''"
                                        :message="errors.balik_aral ? errors.balik_aral[0] : ''">
                                        <b-select expanded
                                            required
                                            icon="keyboard-return"
                                            placeholder="Returnee (Balik-Aral)"
                                            v-model="fields.balik_aral">
                                            <option value="YES">YES</option>
                                            <option value="NO">NO</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>


                            <div class="columns">
                                 <div class="column">
                                    <b-field label="Student ID"
                                        :type="errors.student_id ? 'is-danger':''"
                                        :message="errors.student_id ? errors.student_id[0] : ''" >
                                        <b-input icon="account" 
                                            disabled
                                            maxlength="30"
                                            placeholder="Last Name" v-model="fields.student_id"
                                            type="text" required></b-input>
                                    </b-field>
                                </div>
                            </div>
                         
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Last Name"
                                        :type="errors.lname ? 'is-danger':''"
                                        :message="errors.lname ? errors.lname[0] : ''" >
                                        <b-input icon="account" 
                                            disabled
                                            maxlength="30"
                                            placeholder="Last Name" v-model="fields.lname"
                                            type="text" required></b-input>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="First Name"
                                        :type="errors.fname ? 'is-danger':''"
                                        :message="errors.fname ? errors.fname[0] : ''">
                                        <b-input icon="account" v-model="fields.fname" 
                                            maxlength="30"
                                            disabled
                                            placeholder="First Name"
                                            type="text" required></b-input>
                                    </b-field>
                                </div>
                            </div>


                            <div class="columns">
                                <div class="column">
                                    <b-field label="Middle Name">
                                        <b-input v-model="fields.mname" 
                                            icon="account"
                                            type="text" 
                                            disabled
                                            maxlength="30"
                                            placeholder="Middle Name"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Extension (Jr, III, Sr.)">
                                        <b-input type="text" 
                                        icon="account"
                                            v-model="fields.extension" 
                                            maxlength="10"
                                            disabled
                                            placeholder="Extension (Jr, III, Sr.)"></b-input>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="Sex" expanded
                                        icon="human-non-binary"
                                        :type="errors.sex ? 'is-danger':''"
                                        :message="errors.sex ? errors.sex[0] : ''">
                                        <b-select placeholder="Sex" v-model="fields.sex" icon="account"
                                            required expanded disabled>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Birthdate"
                                        :type="errors.birthdate ? 'is-danger':''"
                                        :message="errors.birthdate ? errors.birthdate[0] : ''">
                                        <b-datepicker v-model="fields.birthdate" 
                                            @input="computeAge"
                                            icon="cake-variant"
                                            disabled
                                            placeholder="Birthdate"
                                            required></b-datepicker>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Birthplace"
                                        :type="errors.birthplace ? 'is-danger':''"
                                        :message="errors.birthplace ? errors.birthplace[0] : ''">
                                        <b-input type="text" 
                                            maxlength="100"
                                            disabled
                                            icon="silverware-fork-knife"
                                            v-model="fields.birthplace" placeholder="Birthplace"></b-input>
                                    </b-field>
                                </div>
                            </div>


                        <!-- SECTIONS/STRANDS/ACADEMIC TRACK -->
                            <div class="divider">SECTIONS/STRANDS/ACADEMIC TRACK</div>
                            
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Grade Level"
                                        expanded
                                        :type="errors.grade_level ? 'is-danger':''"
                                        :message="errors.grade_level ? errors.grade_level[0] : ''" >
                                        <b-select
                                            expanded
                                            icon="star"
                                            placeholder="Grade Level"
                                            v-model="fields.grade_level"
                                            required>
                                            <option :value="{ grade_level: item.grade_level, curriculum_code: item.curriculum_code }"
                                                    v-for="(item, ix) in gradeLevels" :key="`g${ix}`">
                                                {{ item.grade_level }}
                                            </option>
                                        </b-select >
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Section"
                                        expanded
                                        :type="errors.section ? 'is-danger':''"
                                        :message="errors.section ? errors.section[0] : ''" >
                                        <b-select
                                            expanded
                                            icon="star"
                                            placeholder="Section"
                                            v-model="fields.section_id"
                                            required>
                                            <option :value="item.section_id"
                                                    v-for="(item, ix) in sections" :key="`section${ix}`">
                                                {{ item.section }}
                                            </option>
                                        </b-select >
                                    </b-field>
                                </div>
                            </div>

                            <div v-if="fields.balik_aral === 'YES'">
 
                            
                                <div class="columns">
                                    

                                    <div class="column">
                                        <b-field label="Last Year Completed"
                                            :type="errors.last_year_completed ? 'is-danger':''"
                                            :message="errors.last_year_completed ? errors.last_year_completed[0] : ''">
                                            <b-input v-model="fields.last_year_completed"
                                                icon="calendar"
                                                maxlength="20"
                                                type="text" 
                                                placeholder="Last Year Completed"></b-input>
                                        </b-field>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Last School Attended"
                                            :type="errors.last_school_attended ? 'is-danger':''"
                                            :message="errors.last_school_attended ? errors.last_school_attended[0] : ''">
                                            <b-input type="text" v-model="fields.last_school_attended" 
                                                placeholder="Last School Attended"
                                                maxlength="100"></b-input>
                                        </b-field>
                                    </div> <!--col-->
                                    <div class="column">
                                        <b-field label="Last School Id"
                                            :type="errors.last_school_id ? 'is-danger':''"
                                            :message="errors.last_school_id ? errors.last_school_id[0] : ''">
                                            <b-input type="text" v-model="fields.last_school_id" 
                                                maxlength="15"
                                                placeholder="Last School Id"></b-input>
                                        </b-field>
                                    </div> <!--col--> 
                                </div>
                            </div>


                            <div v-if="fields.grade_level.curriculum_code === 'SHS'">
                                <!-- LEARNER IN SHS -->
                                <div class="divider">FOR LEARNERS IN SENIOR HIGH SCHOOL</div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Semester" expanded
                                            :type="errors.semester_id ? 'is-danger':''"
                                            :message="errors.semester_id ? errors.semester_id[0] : ''">
                                            <b-select v-model="fields.semester_id" expanded
                                                icon="account"
                                                placeholder="Semester">
                                                <option :value="item.semester_id" v-for="(item, ix) in semesters" :key="ix">
                                                    {{  item.semester }}
                                                </option>
                                            </b-select>
                                        </b-field>
                                    </div>

                                    <div class="column">
                                        <b-field label="School Id"
                                            :type="errors.senior_high_school_id ? 'is-danger':''"
                                            :message="errors.senior_high_school_id ? errors.senior_high_school_id[0] : ''">
                                            <b-input v-model="fields.senior_high_school_id"
                                                icon="id-card"
                                                maxlength="20"
                                                type="text" placeholder="School Id"></b-input>
                                        </b-field>
                                    </div>
                                </div>


                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Track"
                                                :type="this.errors.track_id ? 'is-danger':''"
                                                :message="this.errors.track_id ? this.errors.track_id[0] : ''">
                                            <b-select v-model="fields.track_id" expanded
                                                    icon="account"
                                                    placeholder="Track"
                                                    @input="loadStrands">
                                                <option :value="item.track_id" v-for="(item, ix) in tracks" :key="`track${ix}`">
                                                    {{  item.track }}
                                                </option>
                                            </b-select>
                                        </b-field>
                                    </div>

                                    <div class="column">
                                        <b-field label="Strand"
                                                :type="this.errors.strand_id ? 'is-danger':''"
                                                :message="this.errors.strand_id ? this.errors.strand_id[0] : ''">
                                            <b-select v-model="fields.strand_id" expanded
                                                    icon="account"
                                                    placeholder="Strand">
                                                <option :value="item.strand_id" v-for="(item, ix) in strands" :key="`strand${ix}`">
                                                    {{  item.strand }}
                                                </option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>
                            </div>

                            
                            


                            <hr>
                            <div class="buttons is-right">
                                <button :class="btnClass">Register</button>
                            </div>

                        </div> <!--panel -body-->
                    </div> <!--panel-->

                </form>
            </div><!--column-->
        </div><!--cols-->
    </section>
</template>

<script>
export default {

    props: ['propData', 'propDataId'],

    data(){
        return{

            id: 0,

            fields: {
                student_id: null,
                learner_status: null,
                grade_level: {
                    grade_level: '',
                    curriculum_code: '',
                },
                balik_aral: null,
                lname: null,
                fname: null,
                mname: null,
                sex:null,
                age: null,
                birthdate: null,
                formatted_bdate: null,
                birthplace: null,

                semester: null,
                track_id: null,
                strand_id: null,

            },

            errors: {},
            gradeLevels: [],
  
            current_provinces: [],
            current_cities: [],
            current_barangays: [],

            permanent_provinces: [],
            permanent_cities: [],
            permanent_barangays: [],

            semesters: [],
            tracks: [],
            strands: [],
            sections: [],

            btnClass: {
                'is-loading': false,
                'button': true,
                'is-primary': true
            }
        }
    },
    methods: {
        //ADDRESS
        loadProvinces: function(){
            axios.get('/load-provinces').then(res=>{
                this.current_provinces = res.data;
                this.permanent_provinces = res.data;
            })
        },
        loadCurrentCities: function(){
            axios.get('/load-cities?prov=' + this.fields.current_province).then(res=>{
                this.current_cities = res.data;
            })
        },

        loadCurrentBarangays: function(){
            axios.get('/load-barangays?prov=' + this.fields.current_province + '&city_code='+this.fields.current_city).then(res=>{
                this.current_barangays = res.data;
            })
        },

        loadPermanentCities: function(){
            axios.get('/load-cities?prov=' + this.fields.permanent_province).then(res=>{
                this.permanent_cities = res.data;
            })
        },

        loadPermanentBarangays: function(){
            axios.get('/load-barangays?prov=' + this.fields.permanent_province + '&city_code='+this.fields.permanent_city).then(res=>{
                this.permanent_barangays = res.data;
            })
        },




        //ADDRESS

        loadSemesters(){
            axios.get('/load-semesters').then(res=>{
                this.semesters = res.data;
            })
        },
        loadTracks(){
            axios.get('/load-tracks').then(res=>{
                this.tracks = res.data;
            })
        },
        loadStrands(){
            axios.get('/load-strands?trackid=' +  this.fields.track_id).then(res=>{
                this.strands = res.data;
            })
        },
        loadGradeLevels(){
            axios.get('/load-grade-levels').then(res=>{
                this.gradeLevels = res.data;
                //console.log(this.gradeLevels);
            })
        },

        loadSections(){
            console.log(this.fields.grade_level.grade_level);

            axios.get('/load-section?grade=' + this.fields.grade_level.grade_level).then(res=>{
                this.sections = res.data;
            })
        },

        computeAge() {
            if(this.fields.birthdate != null){
                var today = new Date();
                var birthDate = new Date(this.fields.birthdate);
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                this.fields.age = age
            }else{
                return 0
            }
           
        },


       


        submit(){
            this.errors = {}; //clear all errors, to refresh errors
            if(this.fields.birthdate ==  null){
                this.$buefy.dialog.alert({
                    title: "EMPTY!",
                    message: 'Birthdate is empty.',
                    type: 'is-danger',
                    onConfirm: ()=>  {
                        return;
                    }
                });
            }


            //alternative
            const formatted_bdate = this.fields.birthdate.getFullYear() + '-' 
                + (this.fields.birthdate.getMonth() + 1).toString().padStart(2, "0") + '-' 
                + (this.fields.birthdate.getDate()).toString().padStart(2,'0')


            this.fields.formatted_bdate = formatted_bdate;

            if(this.id > 0){
                /* update */
                this.btnClass['is-loading'] = true
                axios.put('/manage-learners/' + this.id, this.fields).then(res=>{
                    this.btnClass['is-loading'] = false

                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: "UPDATED!",
                            message: 'Data successfully updated.',
                            type: 'is-success',
                            onConfirm: ()=>  window.location = '/manage-learners'
                        });
                    }
                }).catch(err=>{
                    this.btnClass['is-loading'] = false

                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                        this.$buefy.dialog.alert({
                            title: 'Error!',
                            hasIcon: true,
                            message: 'Some fields are required. Please check fields marked red.',
                            type: 'is-danger',
                        })
                    }else{
                        alert('An error occured.');
                    }
                });
            }else{
                /* insert */
                this.btnClass['is-loading'] = true

                axios.post('/manage-learners', this.fields).then(res=>{
                    this.btnClass['is-loading'] = false

                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: "SAVED!",
                            message: 'Data successfully saved.',
                            type: 'is-success',
                            onConfirm: ()=>  window.location = '/manage-learners'
                        });
                    }
                }).catch(err=>{
                    this.btnClass['is-loading'] = false

                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                        this.$buefy.dialog.alert({
                            title: 'Error!',
                            hasIcon: true,
                            message: 'Some fields are required. Please check fields marked red.',
                            type: 'is-danger',
                        })
                    }else{
                        alert('An error occured.');
                    }
                });
            }

        },

        async initData(){
            await this.loadProvinces();
 
            await this.loadSemesters()
            await this.loadTracks()


            if(this.propDataId > 0){
                this.setData();
            }
        },

        

        async setData(){
            console.log(data)

            this.btnClass['is-loading'] = true

            let data = JSON.parse(this.propData)
            this.id = data.learner_id

            console.log(data)

            this.fields.balik_aral = data.learner.balik_aral
            this.fields.learner_status = data.learner_status

            
            
            this.loadSections()


            this.fields.lrn = data.learner.lrn
            this.fields.student_id = data.learner.student_id
            this.fields.lname = data.learner.lname
            this.fields.fname = data.learner.fname
            this.fields.mname = data.learner.mname
            this.fields.extension = data.learner.extension
            this.fields.sex = data.learner.sex
            this.fields.birthdate = new Date(data.learner.birthdate)
            this.fields.birthplace = data.learner.birthplace
            this.fields.age = data.age
           
            await this.loadGradeLevels()
            this.fields.grade_level = { grade_level: data.grade_level.grade_level, curriculum_code: data.grade_level.curriculum_code }
            await this.loadSections()
            this.fields.section_id = data.section.section_id
            

            // this.fields.semester_id = data.semester_id
            // this.fields.senior_high_school_id = data.senior_high_school_id
            // this.fields.track_id = data.track_id
            // await this.loadStrands()
            // this.fields.strand_id = data.strand_id
            this.btnClass['is-loading'] = false

        },
    },


    mounted() {
        this.initData();
    }

}
</script>

<style scoped>


.box-title{
    font-weight: bold;
    font-size: 1.5rem;
    text-align: left;
}

/*    dere lang kubia ang panel color*/
</style>
