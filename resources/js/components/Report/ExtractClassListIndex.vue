<template>

    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8-widescreen is-10-desktop is-10-tablet">

                    <div class="box">
                        <div class="has-text-weight-bold is-size-4">EXTRACT CLASS LIST</div>
                        <div class="has-text-weight-bold mb-4 is-size-6">
                            Extract Class List from admitted/enrolled learners.
                        </div>
                        <div class="has-text-weight-bold mb-4 info-header">SELECT GRADE LEVEL AND SECTION</div>
                        
                        <div>
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Grade Level"
                                        expanded
                                        :type="errors.grade_level ? 'is-danger':''"
                                        :message="errors.grade_level ? errors.grade_level[0] : ''" >
                                        <b-select
                                            expanded
                                            :loading="gradeLevelLoading"
                                            icon="account"
                                            placeholder="Grade Level"
                                            v-model="fields.grade_level"
                                            @input="loadSections"
                                            required>
                                            <option 
                                                :value="{ grade_level: item.grade_level, curriculum_code: item.curriculum_code }"
                                                    v-for="(item, ix) in gradeLevels" :key="`g${ix}`">
                                                {{ item.grade_level }}
                                            </option>
                                        </b-select >
                                    </b-field>
                                </div> <!--col--> 
                                <div class="column">
                                    <b-field label="Section"
                                        expanded
                                        :type="errors.section_id ? 'is-danger':''"
                                        :message="errors.section_id ? errors.section_id[0] : ''" >
                                        <b-select
                                            :loading="sectionLoading"
                                            expanded
                                            icon="account"
                                            @input="loadAsyncData"
                                            placeholder="Section"
                                            v-model="fields.section"
                                            required>
                                            <option 
                                                :value="{ section_id: item.section_id, section: item.section }"
                                                    v-for="(item, ix) in sections" :key="`section${ix}`">
                                                {{ item.section }}
                                            </option>
                                        </b-select >
                                    </b-field>
                                </div> <!--col--> 
                            </div> <!--cols-->


                            <!-- <div v-if="learner.grade_level.curriculum_code === 'SHS'">

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Semester" expanded
                                            :type="errors.semester_id ? 'is-danger':''"
                                            :message="errors.semester_id ? errors.semester_id[0] : ''">
                                            <b-select v-model="learner.semester_id" expanded
                                                icon="account"
                                                @input="loadSubjectBySemester"
                                                placeholder="Semester">
                                                <option :value="item.semester_id" v-for="(item, ix) in semesters" :key="ix">
                                                    {{  item.semester }}
                                                </option>
                                            </b-select>
                                        </b-field>
                                    </div>

                                
                                </div>


                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Track"
                                                :type="this.errors.track_id ? 'is-danger':''"
                                                :message="this.errors.track_id ? this.errors.track_id[0] : ''">
                                            <b-select v-model="learner.track_id" expanded
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
                                            <b-select v-model="learner.strand_id" expanded
                                                    icon="account"
                                                    placeholder="Strand">
                                                <option :value="item.strand_id" v-for="(item, ix) in strands" :key="`strand${ix}`">
                                                    {{  item.strand }}
                                                </option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>
                            </div> if SHS -->

                        </div>

                        <hr>

                        <div class="my-4">
                            <div class="has-text-weight-bold mb-4 info-header">LIST OF LEARNERS</div>

                            <b-table
                                :data="data"
                                :loading="loading"
                                paginated
                                backend-pagination
                                :total="total"
                                :pagination-rounded="true"
                                :per-page="perPage"
                                @page-change="onPageChange"
                                aria-next-label="Next page"
                                aria-previous-label="Previous page"
                                aria-page-label="Page"
                                aria-current-label="Current page"
                                backend-sorting
                                :default-sort-direction="defaultSortDirection"
                                @sort="onSort">

                                <b-table-column field="learner_id" label="Student Id" sortable v-slot="props">
                                    {{ props.row.learner.student_id }}
                                </b-table-column>

                                <b-table-column field="name" label="Name" v-slot="props">
                                    {{ props.row.learner.lname }}, {{ props.row.learner.fname }} {{ props.row.learner.mname }}
                                </b-table-column>
                                <b-table-column field="extension" label="Extension" v-slot="props">
                                    {{ props.row.learner.extension }}
                                </b-table-column>

                                <b-table-column field="sex" label="Sex" v-slot="props">
                                    {{ props.row.learner.sex }}
                                </b-table-column>

                                <!-- 
                                <b-table-column label="Action" v-slot="props">
                                    <div class="is-flex">
                                        <b-tooltip label="Edit" type="is-warning">
                                            <b-button class="button is-small mr-1" tag="a" icon-right="pencil" 
                                                @click="getData(props.row.faculty_id)"></b-button>
                                        </b-tooltip>
                                        <b-tooltip label="Delete" type="is-danger">
                                            <b-button class="button is-small mr-1" icon-right="delete" 
                                                @click="confirmDelete(props.row.faculty_id)"></b-button>
                                        </b-tooltip>
                                
                                    </div>
                                </b-table-column> -->
                            </b-table>

                            <div>
                                <b>TOTAL NO. ROW(S): {{ reportTotal }}</b>
                            </div>
                            
                        </div> 
                        

                        <div class="has-text-weight-bold mb-4 info-header">CONTROLS/ACTION</div>

                        <div class="buttons mt-4 is-right">
                            <download-excel 
                                :name="reportName"
                                :data="reportData"
                                class="button is-primary has-text-weight-bold">
                                Download Data
                            </download-excel>
                            <!-- <b-button class="is-primary has-text-weight-bold"
                                label="EXTRACT LEARNERS " icon-right="arrow-right"></b-button> -->
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
            data: [],
            total: 0,
            loading: false,
            sortField: 'user_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 10,
            defaultSortDirection: 'asc',

            fields: {
                grade_level: {},
                section: {},
                section_id: null,
                semester_id: null,
                track_id: null,
                strand_id: null,
                learners: []
            },

            errors: {},
            gradeLevels: [],
            semesters: [],
            tracks: [],
            strands: [],
            sections: [],
            reportData: [],

            sectionLoading: false,
            gradeLevelLoading: false
        }
    },

    methods: {
        
        clearFields(){
            this.fields = {
                grade_level: {},
                section_id: null,
                semester_id: null,
                track_id: null,
                strand_id: null,
                learners: []
            };
        },



        //mga init data
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
        async loadStrands() {
            axios.get('/load-strands?trackid=' +  this.data.track_id).then(res=>{
                this.strands = res.data;
            })
        },
        loadGradeLevels(){
            this.gradeLevelLoading = true
            axios.get('/load-grade-levels').then(res=>{
                this.gradeLevelLoading = false
                this.gradeLevels = res.data;
            })
        },
        loadSections(){
            this.sectionLoading = true
            axios.get('/load-section?grade=' + this.fields.grade_level.grade_level).then(res=>{
                this.sectionLoading = false
                this.sections = res.data;
            })
        },

        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `grade=${this.fields.grade_level.grade_level}`,
                `code=${this.fields.grade_level.curriculum_code}`,
                `section=${this.fields.section.section_id}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/report/get-extract-class-list?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                        this.reportData.push({
                            student_id:item.learner.student_id,
                            lastname: item.learner.lname,
                            firstname: item.learner.fname,
                            middlename: item.learner.mname,
                            sex: item.learner.sex,
                            extension: item.learner.extension,
                        })
                    })
                    this.loading = false
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },
        /*
        * Handle page-change event
        */
        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },


    },

    mounted(){
        this.loadGradeLevels()
        this.loadTracks()
        
    },
    computed: {
        reportName(){
            return this.fields.grade_level.grade_level + ' - ' + this.fields.section.section
        },

        reportTotal(){
            return this.data ? this.data.length : 0
        }
    }
}
</script>

<style scoped>
    .box {
        border-top: 2px green;
    }

</style>