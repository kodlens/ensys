<template>
    <div>
        <div class="print-area">

            <div class="has-text-weight-bold has-text-centered" style="">
                CERTIFICATE OF ENROLLMENT
            </div>

            <div class="has-text-weight-bold has-text-centered mb-4" v-if="learner.academic_year">
                {{ learner.academic_year.academic_year_code }} - {{ learner.academic_year.academic_year_desc }}
            </div>

            <div class="is-flex is-justify-content-space-between">
                <div>
                    <div> 
                        NAME:  
                        <span v-if="learner.learner">
                            {{ learner.learner.lname }}, {{ learner.learner.fname }} {{ learner.learner.mname }}
                        </span>
                    </div>

                    <div> 
                        GRADE LEVEL & SECTION:  
                        <span v-if="learner.learner">
                            {{ learner.learner.grade_level }} - {{ learner.section.section }}
                        </span>
                    </div>

                    <div> 
                        TRACK & STRAND:  
                        <span v-if="learner.track">
                            {{ learner.track.track }} - {{ learner.strand.strand }}
                        </span>
                        <span v-else>N/A</span>
                    </div>
                </div>

                <div>
                    <qrcode :value="JSON.stringify(student)" :options="{ width: 100 }"></qrcode>             
                </div>
            </div>
            


            <div class="has-text-weight-bold mb-2 has-text-centered">SUBJECTS</div>
            <table class="report-subject-table">
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th style="text-align: center;">Time</th>
                    <th>Day</th>
                    <th>Teacher</th>
                </tr>
                <tr v-for="(item, index) in learner.section_subjects" :key="`sub${index}`">
                    <td>{{ item.subject.subject_code }}</td>
                    <td style="width: 200px;">{{ item.subject.subject_description }}</td>
                    <td style="width: 120px; text-align: center;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 150px;">
                        <span v-if="item.teacher">
                            {{ item.teacher.lname }}, {{ item.teacher.fname }} {{ item.teacher.mname }}
                        </span>
                        <span v-else>
                            
                        </span>
                    </td>
                </tr>
            </table>

            <div class="nprint">
                <b-button 
                    class="mt-5 is-small" 
                    onclick="window.history.back()" icon-right="arrow-left">BACK</b-button>

                    <b-button 
                        class="mt-5 is-small" 
                        onclick="window.print()" icon-right="printer">PRINT</b-button>
            </div>

        </div>

        
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

            student: {
                lrn: '',
                lname: '',
                fname: '',
                mname: '',
                sex: ''
            }
        }
    },

    methods: {
        loadReportLearner(){
            axios.get('/get-report-learner/' + this.propLearnerId + '/' + this.propAcademicYearId).then(res=>{
                this.learner = res.data

                this.student.lrn = res.data.learner.lrn;
                this.student.lname = res.data.learner.lname;
                this.student.fname = res.data.learner.fname;
                this.student.mname = res.data.learner.mname;
                this.student.sex = res.data.learner.sex;


            })
        },
    },

    mounted(){
        this.loadReportLearner()
    }
}
</script>

<style scoped>
    @media print {
        @page {
            size: A4 portrait !important;
        }

        .print-area{
           margin: 25px;
           width: 100vw;
        }

        .coe {
            margin: 0 auto;
        }
     
         .report-subject-table {
            padding: 0 10px;
            width: 100%;
        }

        header, footer, aside, nav, form, iframe, .menu, .hero, .adslot, .nprint {
            display: none;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .buttons{
            display: none;
        }
    }

    .print-area{
        font-size: 12px;
        width: 640px;
        margin: 10px auto;
    }

    .report-subject-table th{
         border-top: 1px solid gray;
         border-bottom: 1px solid gray;
         padding: 10px 10px;
    }
    .report-subject-table tr th {
        padding: 0 8px;
    }
    .report-subject-table tr td {
        padding: 4px 8px;
        border-bottom: 1px solid rgb(211, 211, 211);
    }



</style>