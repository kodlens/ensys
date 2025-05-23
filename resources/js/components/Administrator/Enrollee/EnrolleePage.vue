<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8-dekstop is-10-tablet">
                    <div class="box">

                        <div class="has-text-weight-bold is-size-4">ENROLLEES</div>
                        <div class="has-text-weight-bold mb-4 is-size-6">
                            List of enrollees of the selected Academic Year.
                        </div>


                        <div class="columns">
                            <div class="column">
                                <b-field label="Academic Year" expanded>
                                    <b-select v-model="search.ayid" 
                                        expanded
                                        placeholder="Academic Year"
                                        @keyup.native.enter="loadAsyncData">
                                        <option v-for="(item, ix) in academicYears" :key="`ay${ix}`" 
                                            :value="item.academic_year_id">
                                            {{ item.academic_year_code }} - {{ item.academic_year_desc }}
                                        </option>
                                    </b-select>
                                        
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Grade Level" expanded>
                                    <b-select v-model="search.grade_level" 
                                        expanded
                                        @input="loadSemesters"
                                        placeholder="Grade Level">
                                        <option :value="{ grade_level: '', curriculum_code: ''}">ALL</option>
                                        <option v-for="(item, ix) in gradeLevels" :key="`grade${ix}`" 
                                            :value="{ grade_level: item.grade_level, curriculum_code: item.curriculum_code }">
                                            {{ item.grade_level }} ({{ item.curriculum_code }})
                                        </option>
                                    </b-select>
                                </b-field>
                            </div>

                            <div class="column" v-if="search.grade_level.curriculum_code === 'SHS'">
                                <b-field label="Semester" expanded>
                                    <b-select v-model="search.semester" 
                                        expanded
                                        placeholder="Semester">
                                        <option v-for="(item, ix) in semesters" :key="`sem${ix}`" 
                                            :value="item.semester_id">
                                            {{ item.semester }}
                                        </option>
                                    </b-select>
                                </b-field>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column">
                                <b-field label="Search">
                                    <b-input type="text"
                                        v-model="search.name" placeholder="Search Lastname"
                                        @keyup.native.enter="loadAsyncData"/>
                                </b-field>
                            </div>
                        </div>


                        <div class="buttons">
                            <b-button type="is-primary" 
                                label="SEARCH"
                                icon-right="account-filter" @click="loadAsyncData"/>
                        </div>

                        <!-- <div class="buttons is-right mt-3">
                            <b-button tag="a" href="/enrollee/create"
                                  icon-left="plus"
                                  class="is-primary is-small">ADD LEARNER</b-button>
                        </div> -->

                        <b-table
                            :data="data"
                            :loading="loading"
                            paginated
                            detailed
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


                            <b-table-column field="lname" label="Name" sortable v-slot="props">
                                {{ props.row.learner.lname }}, {{ props.row.learner.fname }} {{ props.row.learner.mname }}
                            </b-table-column>

                            <b-table-column field="sex" label="Sex" v-slot="props">
                                {{ props.row.learner.sex }}
                            </b-table-column>

                            <b-table-column field="grade_level" label="Grade Level" v-slot="props">
                                {{ props.row.grade_level }}
                            </b-table-column>

                            <b-table-column field="grade_level" label="Enrollment Status" v-slot="props">
                                <span class="green" v-if="props.row.status === 'ENROL'">ENROLED</span>
                                <span class="red" v-if="props.row.status === 'WITHDRAW'">WITHDRAWED</span>
                                <span class="red" v-if="props.row.status === 'DROP'">DROPPED</span>
                                <span class="blue" v-if="props.row.status === 'TRANSFER'">TRANSFERED</span>
                            </b-table-column>

                            <b-table-column field="track_strand" label="Track/Strand" v-slot="props">
                                <span v-if="props.row.track">
                                    {{ props.row.track.track }}
                                </span>

                                <span v-if="props.row.strand">
                                    / {{ props.row.strand.strand }}

                                </span>

                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">

                                    <b-tooltip label="Payment History" type="is-warning">
                                        <b-button class="button is-small mr-1"
                                            icon-right="history" 
                                            @click="getData(props.row.learner_id)"></b-button>
                                    </b-tooltip>

                                     <b-tooltip label="Edit" type="is-info">
                                        <b-button class="button is-small mr-1" 
                                            :href="'/enrollee/' + props.row.enroll_id + '/edit'"
                                            tag="a" icon-right="pencil"></b-button> 
                                    </b-tooltip>

                                    <b-tooltip label="Withdraw Enrolment" type="is-info">
                                        <b-button class="button is-small mr-1" 
                                            icon-right="sign-real-estate" 
                                            @click="openCancelEnrolment(props.row.enroll_id)"></b-button>
                                    </b-tooltip>

                                    <b-tooltip label="Print COE" type="is-info">
                                         <b-button tag="a" 
                                            :href="`/print-coe/${props.row.learner_id}/${search.ayid}`"
                                            class="is-small is-outlined is-primary"
                                            icon-left="printer"></b-button>
                                    </b-tooltip>
                                </div>

                            </b-table-column>

                            <template #detail="props">
                                <div class="columns">
                                    <div class="column">
                                        <div class="has-text-weight-bold is-size-6">SECTION: {{ props.row.section.section }}</div>
                                    </div>
                                    <div class="column">
                                        <div class="has-text-weight-bold is-size-6">TRACK: 
                                            <span v-if="props.row.track">
                                                {{ props.row.track.track }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="columns">
                                   
                                    <div class="column">
                                        <div class="has-text-weight-bold is-size-6">STRAND: 
                                            <span v-if="props.row.strand">
                                                {{ props.row.track.strand }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="has-text-weight-bold is-size-6">
                                            SEMESTER: 
                                            <span v-if="props.row.semester">
                                                {{ props.row.semester.semester }}
                                            </span>
                                        </div>
                                    </div>
                                   
                                </div>

                                <p class="has-text-weight-bold is-size-6 mb-4">SUBJECTS</p>
                                <table class="table">
                                    <tr>
                                        <th>Code</th>
                                        <th>Description</th>
                             
                                    </tr>
                                    <tr v-for="(item, ix) in props.row.section_subjects" :key="`subj${ix}`">
                                        <td>{{ item.subject.subject_code }}</td>
                                        <td>{{ item.subject.subject_description }}</td>
                                    </tr>
                                </table>

                                <div class="buttons">
                                    <b-button tag="a" 
                                        :href="`/print-coe/${props.row.learner_id}/${search.ayid}`"
                                        class="is-small is-outlined is-info mt-2"
                                        icon-left="printer">PRINT COE</b-button>
                                </div>
                            </template>
                        </b-table>

                        <div class="columns">
                            <div class="column">
                                <b-field label="Page" label-position="on-border">
                                    <b-select v-model="perPage" @input="setPerPage" class="is-small">
                                        <option value="5">5 per page</option>
                                        <option value="10">10 per page</option>
                                        <option value="15">15 per page</option>
                                        <option value="20">20 per page</option>
                                    </b-select>
                                </b-field>
                            </div>
                        </div>

                    </div>
                </div><!--col -->
            </div><!-- cols -->
        </div><!--section div-->


        <!--modal reset password-->
        <b-modal v-model="modalCancelEnrolment" has-modal-card
            trap-focus
            :width="640"
            aria-role="dialog"
            aria-label="Modal"
            aria-modal>

            <form @submit.prevent="resetPassword">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">CHANGE ENROLMENT STATUS</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalCancelEnrolment = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Password" label-position="on-border"
                                        expanded
                                        :type="this.errors.password ? 'is-danger':''"
                                        :message="this.errors.password ? this.errors.password[0] : ''">
                                        <b-select expanded 
                                            v-model="fields.is_enrolled"
                                            placeholder="Enrolment Status" required>
                                            <option value="WITHDRAWED">WITHDRAWED</option>
                                            <option value="DROP">DROP OUT</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button
                            class="button is-primary">SAVE</button>
                    </footer>
                </div>
            </form>
        </b-modal> 
        <!--close modal-->


    </div>
</template>

<script>

export default{

    data() {
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'enroll_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 10,
            defaultSortDirection: 'asc',

            global_id : 0,

            search: {
                ayid: '',
                name: '',
                grade_level: { grade_level: '' },
                semester: null
            },

            modalCancelEnrolment: false,
            
            fields: {},
            errors: {},

            academicYears: [],
            gradeLevels: [],
            semesters: [],

        }

    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `name=${this.search.name}`,
                `ayid=${this.search.ayid}`,
                `grade=${this.search.grade_level.grade_level}`,
                `semester=${this.search.semester}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-enrollees?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
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


        //alert box ask for deletion
        confirmDelete(dataId) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(dataId)
            });
        },
        //execute delete after confirming
        deleteSubmit(dataId) {
            axios.delete('/enrollee/' + dataId).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        //update code here
        getData: function(data_id){
            window.location = '/payment-history/' + data_id
        },


        async loadAcademicYears(){
            await axios.get('/load-academic-years').then(res=>{
                this.academicYears = res.data

                this.academicYears.forEach(item =>{
                    if(item.is_active === 1){
                        this.search.ayid = item.academic_year_id
                    }
                })
            }).catch(err=>{
            
            })
        },

        async loadGradeLevels(){
            await axios.get('/load-grade-levels').then(res=>{
                this.gradeLevels = res.data

                this.search.grade_level.grade_level = ''
            })
        },

        loadSemesters(){

            if(this.search.grade_level.curriculum_code === 'SHS'){
                axios.get('/load-semesters').then(res=>{
                    this.semesters = res.data
                })
            }else{
                this.search.semester = null
            }
            
        },


        /** this is modal for change status of the student */
        openCancelEnrolment(dataId){
            //this.modalCancelEnrolment = true
            window.location = '/enrollee-update-status/' +dataId
        },
        confirmWithdraw(dataId){
            axios.post('/enrollee-withdraw/' +dataId).then(res=>{
                if(res.data.status === 'withdraw'){
                    this.$buefy.dialog.alert({
                        title: 'Success',
                        type: 'is-success',
                        message: 'Successfully withdraw',
                        onConfirm: () => this.loadAsyncData()
                    });
                }
            })
        }


    },

    mounted() {
        this.loadAcademicYears().then(()=>{
            this.loadGradeLevels().then(()=>{
                this.loadAsyncData()
            })
        })
  
    }

}


</script>


<style scoped>

    .green{
        font-weight: bold;
        font-size: 12px;
        padding: 5px;
        border-radius: 5px;
        background-color: green;
        color: white;
    }

    .blue{
        font-weight: bold;
        font-size: 12px;
        padding: 5px;
        border-radius: 5px;
        background-color: #2335a0;
        color: #ffffff;
    }

    .red {
        font-weight: bold;
        font-size: 12px;
        padding: 5px;
        border-radius: 5px;
        background-color: #af2424;
        color: #ffffff;
    }

</style>
