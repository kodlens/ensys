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

                    data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                        this.reportData.push({
                            'Student Id': item.learner.student_id,
                            'Last Name': item.learner.lname,
                            'First Name': item.learner.fname,
                            'Middle Name': item.learner.mname,
                            'Sex': item.learner.sex,
                            'Extension': item.learner.extension,
                            'Grade Level': item.learner.grade_level,
                            'Balik Aral': item.learner.balik_aral,
                            'PSA': item.learner.psa,

                            'LRN': item.learner.lrn ?  "'" + item.learner.lrn : '',
                            'Birthdate': item.learner.birthdate,
                            'Birthplace': item.learner.birthplace,
                            'Age': item.learner.age,
                            'Mother Tongue': item.learner.mother_tongue,
                            'Is Indigenous': item.learner.is_indigenous ? 'YES' : 'NO',
                            'If Yes, Indigenous': item.learner.if_yes_indigenous,
                            'Is 4Ps': item.learner.is_4ps ? 'YES' : 'NO',
                            'Household 4Ps ID No.': item.learner.household_4ps_id_no,

                            // Current Address
                            'Current Province': item.learner.current_province ? item.learner.current_province.provDesc : '',
                            'Current City': item.learner.current_city ? item.learner.current_city.citymunDesc : '',
                            'Current Barangay': item.learner.current_barangay ? item.learner.current_barangay.brgyDesc : '',
                            'Current Street': item.learner.current_street,
                            'Current Zipcode': item.learner.current_zipcode,

                            // Permanent Address
                            'Permanent Province': item.learner.permanent_province ? item.learner.permanent_province.provDesc : '',
                            'Permanent City': item.learner.permanent_city ? item.learner.permanent_city.citymunDesc : '',
                            'Permanent Barangay': item.learner.permanent_barangay ? item.learner.permanent_barangay.brgyDesc : '',
                            'Permanent Street': item.learner.permanent_street,
                            'Permanent Zipcode': item.learner.permanent_zipcode,

                            // Father
                            'Father Last Name': item.learner.father_lname,
                            'Father First Name': item.learner.father_fname,
                            'Father Middle Name': item.learner.father_mname,
                            'Father Extension': item.learner.father_extension,
                            'Father Contact No.': item.learner.father_contact_no,

                            // Mother
                            'Mother Maiden Last Name': item.learner.mother_maiden_lname,
                            'Mother Maiden First Name': item.learner.mother_maiden_fname,
                            'Mother Maiden Middle Name': item.learner.mother_maiden_mname,
                            'Mother Maiden Contact No.': item.learner.mother_maiden_contact_no,

                            // Guardian
                            'Guardian Last Name': item.learner.guardian_lname,
                            'Guardian First Name': item.learner.guardian_fname,
                            'Guardian Middle Name': item.learner.guardian_mname,
                            'Guardian Extension': item.learner.guardian_extension,
                            'Guardian Contact No.': item.learner.guardian_contact_no,
                            'Guardian Relationship': item.learner.guardian_relationship,

                            // Last School Info
                            'Last Grade Level': item.learner.last_grade_level,
                            'Last Year Completed': item.learner.last_year_completed,
                            'Last School Attended': item.learner.last_school_attended,
                            'Last School ID':  item.learner.last_school_id ? "'" + item.learner.last_school_id : '',

                            // SHS Info
                            'Semester ID': item.learner.semester ? item.learner.semester.semester : '',
                            'Senior High School ID': item.learner.senior_high_school_id ? "'" + item.learner.senior_high_school_id : '',
                            'Track': item.track ? item.track.track : '',
                            'Strand': item.strand ? item.strand.strand : '',
                            'Stran Description': item.strand ? item.strand.strand_desc : '',

                        });
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