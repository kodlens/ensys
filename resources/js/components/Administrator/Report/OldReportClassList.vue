<template>
    <div class="print-area">
        <div class=" mt-4" v-for="(item, index) in classLists" :key="index">
            
            <div class="page-break" v-if="item.enrollees.length > 0">
                <div class="has-text-weight-bold has-text-centered is-size-6">
                    CLASS LIST
                </div>
                
                <div class="has-text-weight-bold has-text-centered mb-4 is-size-6" v-if="academicYear">
                    {{ academicYear.academic_year_code }} - {{ academicYear.academic_year_desc }}
                </div>

                <div class="has-text-centered has-text-weight-bold">
                   {{ item.grade_level }} - {{ item.section }}
                </div>

                <div class="columns">
                    
                    <div class="column">
                        <div class="has-text-weight-bold">MALE</div>
                        <div v-for="(enroll, index) in item.enrollees.filter( f => f.sex === 'MALE')" :key="`$enrolleesMale${index}`">
                            <span>{{ index + 1 }}. </span>{{ enroll.lname }},  {{ enroll.fname }} {{ enroll.mname }}
                        </div>
                    </div>

                    <div class="column">
                        <div class="has-text-weight-bold">FEMALE</div>
                        <div v-for="(enroll, index) in item.enrollees.filter ( f => f.sex === 'FEMALE' )" :key="`$enrolleesFemale${index}`">
                            <span>{{ index + 1 }}. </span>{{ enroll.lname }},  {{ enroll.fname }} {{ enroll.mname }}
                        </div>
                    </div>
                </div>

                <div class="has-text-centered">
                    <div>TOTAL NO. OF STUDENT(S): <b>{{ item.enrollees.length }}</b></div>
                    **END SECTION**
                </div>
            
            </div>
            
        </div><!--loop-->
    </div>
</template>

<script>

export default{
    props:{
        propAcademicYearId: {
            type: Number,
            default: 0
        },
        propLearnerId: {
            type: Number,
            default: 0
        }
    },
    
    data(){
        return {
            learner: {},

            classLists: [],
            academicYear: {},
        }
    },

    methods: {
        loadReportLearner(){
            axios.get('/get-report-class-list').then(res=>{
                this.classLists = res.data
            })
        },

        loadActiveAcademicYear(){
            axios.get('/load-academic-year').then(res=>{
                this.academicYear = res.data
            })
   
        }
    },

    mounted(){
        this.loadActiveAcademicYear()
        this.loadReportLearner()
    }
}
</script>


<style scoped>
    
</style>