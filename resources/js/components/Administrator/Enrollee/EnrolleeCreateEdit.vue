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

                            <b-notification 
                                type="is-warning is-light" 
                                aria-close-label="Close notification">
                                Only enabled fields can be updated.
                            </b-notification>

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
                                            <option value="OLD">OLD</option>
                                            <option value="NEW">NEW</option>
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
                                            disabled
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
                                    <b-field label="Academic Year" expanded
                                        :type="errors.academic_year_id ? 'is-danger':''"
                                        :message="errors.academic_year_id ? errors.academic_year_id[0] : ''">
                                        <b-select 
                                            v-model="fields.academic_year_id" 
                                            expanded
                                            icon="calendar"
                                            placeholder="Academic Year">
                                            <option 
                                                :value="item.academic_year_id" 
                                                v-for="(item, ix) in academicYears" :key="`ay${ix}`">
                                                {{  item.academic_year_code }} - {{ item.academic_year_desc   }}
                                            </option>
                                        </b-select>
                                    </b-field>
                                </div>
                                
                            </div>
                            
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
                                            @input="loadSections"
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
                                <button :class="btnClass">Update Information</button>
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
                academic_year_id: null,
                semester_id: null,
                track_id: null,
                strand_id: null,

            },

            errors: {},
            gradeLevels: [],
            academicYears: [],
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
        // loadProvinces: function(){
        //     axios.get('/load-provinces').then(res=>{
        //         this.current_provinces = res.data;
        //         this.permanent_provinces = res.data;
        //     })
        // },
        // loadCurrentCities: function(){
        //     axios.get('/load-cities?prov=' + this.fields.current_province).then(res=>{
        //         this.current_cities = res.data;
        //     })
        // },

        // loadCurrentBarangays: function(){
        //     axios.get('/load-barangays?prov=' + this.fields.current_province + '&city_code='+this.fields.current_city).then(res=>{
        //         this.current_barangays = res.data;
        //     })
        // },

        // loadPermanentCities: function(){
        //     axios.get('/load-cities?prov=' + this.fields.permanent_province).then(res=>{
        //         this.permanent_cities = res.data;
        //     })
        // },

        // loadPermanentBarangays: function(){
        //     axios.get('/load-barangays?prov=' + this.fields.permanent_province + '&city_code='+this.fields.permanent_city).then(res=>{
        //         this.permanent_barangays = res.data;
        //     })
        // },


        async loadAcademicYears(){
            axios.get('/load-academic-years').then(res=>{
                this.academicYears = res.data;
            })
        },
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
        async loadGradeLevels(){
            axios.get('/load-grade-levels').then(res=>{
                this.gradeLevels = res.data;
            })
        },

        async loadSections(){
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

            this.btnClass['is-loading'] = true
            axios.put('/enrollee/' + this.propDataId, this.fields).then(res=>{
                this.btnClass['is-loading'] = false

                if(res.data.status === 'updated'){
                    this.$buefy.dialog.alert({
                        title: "UPDATED!",
                        message: 'Learner successfully updated.',
                        type: 'is-success',
                        onConfirm: ()=>  window.location = '/enrollee'
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

        },

        async initData(){
            //await this.loadProvinces();
            this.loadAcademicYears()
            this.loadTracks()

            if(this.propDataId > 0){
                this.setData();
            }
        },

        

        async setData(){
            this.btnClass['is-loading'] = true

            let data = JSON.parse(this.propData)
            this.id = data.learner_id

            this.fields.balik_aral = data.learner.balik_aral
            this.fields.learner_status = data.learner_status
            
            this.loadSections()

            this.fields.learner_status = data.learner_status
            this.fields.student_id = data.learner.student_id
            this.fields.lname = data.learner.lname
            this.fields.fname = data.learner.fname
            this.fields.mname = data.learner.mname
            this.fields.extension = data.learner.extension
            this.fields.sex = data.learner.sex
            this.fields.birthdate = new Date(data.learner.birthdate)
            this.fields.birthplace = data.learner.birthplace
            this.fields.age = data.age
            
         
            this.fields.academic_year_id = data.academic_year_id
            await this.loadSemesters()
            this.fields.semester_id = data.semester_id
            
            
            await this.loadGradeLevels().then(()=>{
                this.fields.grade_level = { grade_level: data.grade_level.grade_level, curriculum_code: data.grade_level.curriculum_code }

                this.loadSections().then(()=>{
                    this.fields.section_id = data.section.section_id
                })
            })

            
            this.fields.track_id = data.track_id
            await this.loadStrands()
            this.fields.strand_id = data.strand_id
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
