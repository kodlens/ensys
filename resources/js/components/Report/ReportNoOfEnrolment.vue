<template>
    <section class="section">
        <div class="columns">
            <div class="column">
                

                <div class="report-container">
                    <div class="has-text-weight-bold">
                        NO OF ENROLLEES 
                    </div>
                    <div class="has-text-weight-bold mb-2">
                        <span v-if="academicYears">{{ academicYears.academic_year_desc }}</span>
                    </div>
                    <table>
                        <tr>
                            <th>LEGEND</th>
                            <th>GRADE 7</th>
                            <th>GRADE 8</th>
                            <th>GRADE 9</th>
                            <th>GRADE 10</th>
                            <th>GRADE 11</th>
                            <th>GRADE 12</th>
                        </tr>
                        <tr v-for="(item, index) in enrolments">
                            <td>
                                <span class="ml-4">
                                    {{ item.legends }}
                                </span>
                            </td>
                            <td>
                                <span class="ml-4">
                                    {{ item.grade_7 }}
                                </span>
                            </td>
                            <td>
                                <span class="ml-4">
                                    {{ item.grade_8 }}
                                </span>
                            </td>
                            <td>
                                <span class="ml-4">
                                    {{ item.grade_9 }}
                                </span>
                            </td>
                            <td>
                                <span class="ml-4">
                                    {{ item.grade_10 }}
                                </span>
                            </td>
                            <td>
                                <span class="ml-4">
                                    {{ item.grade_11 }}
                                </span>
                            </td>
                            <td>
                                <span class="ml-4">
                                    {{ item.grade_12 }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
             
        </div>
        
    </section>
</template>

<script>
export default {
    data() {
        return {
            enrolments: [],
            academicYears: {}
        }
    },
    methods: {
        loadEnrolment(){
            axios.get('/get-report-no-of-enrolment').then(res=>{
                this.enrolments = res.data.reports
                this.academicYears = res.data.ay
            })
        }
    },

    mounted() {
        this.loadEnrolment()
    }
}
</script>

<style scoped>

    .report-container{
        width: 640px;
        margin: auto;
        border: 1px solid gray;
        padding: 15px;
    }
    

    table tr th {
        width: 100px;
    }
</style>