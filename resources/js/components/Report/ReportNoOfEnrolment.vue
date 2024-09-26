<template>
    <section>
        <div class="columns">
            <div class="column">
                <div>
                    No of enrolment
                </div>

                <div>
                    <table>
                        <tr>
                            <th>G7</th>
                            <th>G8</th>
                            <th>G9</th>
                            <th>G10</th>
                            <th>G11</th>
                            <th>G12</th>
                        </tr>
                        <!-- GRADE 7 -->
                        <tr v-for="(item, index) in enrolments">
                            <td v-if="item.grade_level === 'GRADE 7' && item.sex === 'MALE'">
                                <span class="has-text-weight-bold">M</span>
                                <span class="ml-4">
                                    {{ item.by_sex }}
                                </span>
                            </td>
                        </tr>
                        <tr v-for="(item, index) in enrolments">
                            <td v-if="item.grade_level === 'GRADE 7' && item.sex === 'FEMALE'">
                                <span class="has-text-weight-bold">F</span>
                                <span class="ml-4">
                                    {{ item.by_sex }}
                                </span>
                            </td>
                        </tr>
                        <tr v-for="(item, index) in enrolments">
                            <td v-if="item.grade_level === 'GRADE 7' && item.sex === 'FEMALE'">
                                <span class="has-text-weight-bold">T</span>
                                <span class="ml-4">
                                    {{ item.total }}
                                </span>
                            </td>
                        </tr>
                        <!-- GRADE 8 -->
                        <tr v-for="(item, index) in enrolments">
                            <td v-if="item.grade_level === 'GRADE 8' && item.sex === 'MALE'">
                                <span class="has-text-weight-bold">M</span>
                                <span class="ml-4">
                                    {{ item.by_sex }}
                                </span>
                            </td>
                        </tr>
                        <tr v-for="(item, index) in enrolments">
                            <td v-if="item.grade_level === 'GRADE 8' && item.sex === 'FEMALE'">
                                <span class="has-text-weight-bold">F</span>
                                <span class="ml-4">
                                    {{ item.by_sex }}
                                </span>
                            </td>
                        </tr>
                        <tr v-for="(item, index) in enrolments">
                            <td v-if="item.grade_level === 'GRADE 8' && item.sex === 'FEMALE'">
                                <span class="has-text-weight-bold">T</span>
                                <span class="ml-4">
                                    {{ item.total }}
                                </span>
                            </td>
                        </tr>
                        <!-- GRADE 9 -->

                        <tr v-for="(item, index) in enrolments">
                            <td v-if="item.grade_level === 'GRADE 9' && item.sex === 'MALE'">
                                <span class="has-text-weight-bold">M</span>
                                <span class="ml-4">
                                    {{ item.by_sex }}
                                </span>
                            </td>
                        </tr>
                        <tr v-for="(item, index) in enrolments">
                            <td v-if="item.grade_level === 'GRADE 9' && item.sex === 'FEMALE'">
                                <span class="has-text-weight-bold">F</span>
                                <span class="ml-4">
                                    {{ item.by_sex }}
                                </span>
                            </td>
                        </tr>
                        <tr v-for="(item, index) in enrolments">
                            <td v-if="item.grade_level === 'GRADE 9' && item.sex === 'FEMALE'">
                                <span class="has-text-weight-bold">T</span>
                                <span class="ml-4">
                                    {{ item.total }}
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
            enrolments: {}
        }
    },
    methods: {
        loadEnrolment(){
            axios.get('/get-report-no-of-enrolment').then(res=>{
                this.enrolments = res.data
            })
        }
    },

    mounted() {
        this.loadEnrolment()
    }
}
</script>

<style scoped>
    table tr th {
        width: 100px;
    }
</style>