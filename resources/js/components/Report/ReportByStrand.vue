<template>
    <div class="report-container">
        <div class="has-text-weight-bold">
            NO OF ENROLLEES BY STRAND
        </div>
        <div class="has-text-weight-bold mb-2">
            <span v-if="academicYears">{{ academicYears.academic_year_desc }}</span>
        </div>
        <table>
            <tr>
                <th>LEGEND</th>
                <th>STEM</th>
                <th>HUMSS</th>
                <th>GAS</th>
                <th>ABM</th>
                <th>ICT - CSS</th>
                <th>ICT - CP</th>
                <th>IA - EIM</th>
                <th>HE - TOURISM</th>
                <th>HE - COOKERY</th>
            </tr>
            <tr v-for="(item, index) in enrolments">
                <td>
                    <span class="ml-4">
                        {{ item.legends }}
                    </span>
                </td>
                <td>
                    <span class="ml-4">
                        {{ item.stem }}
                    </span>
                </td>
                <td>
                    <span class="ml-4">
                        {{ item.humss }}
                    </span>
                </td>
                <td>
                    <span class="ml-4">
                        {{ item.gas }}
                    </span>
                </td>
                <td>
                    <span class="ml-4">
                        {{ item.abm }}
                    </span>
                </td>
                <td>
                    <span class="ml-4">
                        {{ item.ict_css }}
                    </span>
                </td>
                <td>
                    <span class="ml-4">
                        {{ item.ict_cp }}
                    </span>
                </td>
                <td>
                    <span class="ml-4">
                        {{ item.ia_electric }}
                    </span>
                </td>
                <td>
                    <span class="ml-4">
                        {{ item.he_tourism }}
                    </span>
                </td>
                <td>
                    <span class="ml-4">
                        {{ item.he_cookery }}
                    </span>
                </td>
            </tr>
        </table>
    </div>
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
            axios.get('/get-report-by-strand').then(res=>{
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
        width: 1120px;
        margin: auto;
        border: 1px solid gray;
        padding: 15px;
    }
    

    table tr th {
        width: 100px;
    }
</style>

