<template>
    <div>
        <b-field label="Subject">
            <b-input 
                :value="valueFullname" 
                expanded
                icon="account" placeholder="Select Bill" required readonly>
            </b-input>

            <p class="control">
                <b-button class="button is-primary" @click="openModal">...</b-button>
            </p>
        </b-field>


        <b-modal v-model="isModalActive" has-modal-card
                 trap-focus scroll="keep" aria-role="dialog" aria-modal>
            <div class="modal-card card-width">
                <header class="modal-card-head">
                    <p class="modal-card-title has-text-weight-bold is-size-6">SELECT SUBJECTS</p>
                    <button type="button" class="delete"
                        @click="isModalActive = false"/>
                </header>

                <section class="modal-card-body">
                    <div>

                        <b-field label="Subject" 
                            label-position="on-border">
                            <b-input type="text" 
                                v-model="search.code" 
                                @keyup.native.enter="loadAsyncData"
                                placeholder="Search Code..." 
                                expanded auto-focus></b-input>
                            <b-input type="text" 
                                v-model="search.subject" 
                                @keyup.native.enter="loadAsyncData"
                                placeholder="Search Subject..." 
                                expanded auto-focus></b-input>
                        </b-field>

                        <div class="table-container">
                            <b-table
                                :data='data'
                                :loading="loading"
                                paginated
                                backend-pagination
                                :total='total'
                                :per-page="perPage"
                                @page-change="onPageChange"
                                detail-transition=""
                                aria-next-label="Next page"
                                aria-previous-label="Previouse page"
                                aria-page-label="Page"
                                :show-detail-icon=true
                                aria-current-label="Current page"
                                default-sort-direction="defualtSortDirection"
                                @sort="onSort">

                                <b-table-column field="subject_id" label="Subject Id" v-slot="props">
                                    {{props.row.subject_id}}
                                </b-table-column>

                                <b-table-column field="subject_code" label="Subject Code" v-slot="props">
                                    {{props.row.subject_code}}
                                </b-table-column>

                                <b-table-column field="subject_description" label="Description" v-slot="props">
                                    {{props.row.subject_description}}
                                </b-table-column>

                                <b-table-column field="" label="Action" v-slot="props">
                                    <div class="buttons">
                                        <b-button class="is-small is-rounded is-primary" 
                                            icon-left="arrow-right"
                                            @click="selectData(props.row)">
                                            SELECT
                                        </b-button>
                                    </div>
                                </b-table-column>
                            </b-table>
                        </div>

                    </div>
                </section>

                <footer class="modal-card-foot">
                    <b-button
                        label="Close"
                        @click="isModalActive=false"></b-button>
                </footer>
            </div>
        </b-modal>


    </div>
</template>

<script>
export default {
    props: {
        propName: {
            type: String,
            default: '',
        },

    },
    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortfield: 'subject_id',
            sortOrder:'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection:'',

            isModalActive: false,
            errors:{},

            learner: {
                fullname: '',
            },
            search: {
                code: '',
                subject: ''
            },

            academicYears: [],

            

        }
    },
    methods: {
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortfield}.${this.sortOrder}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`,
                `code=${this.search.code}`,
                `subject=${this.search.subject}`,
            ].join('&');

            this.loading = true;
            axios.get(`/get-modal-browse-subjects?${params}`).then(({data}) => {
                this.data = [];
                let currentTotal = data.total;
                if (data.total / this.perPage > 1000) {
                    currentTotal = this.perPage * 1000;
                }

                this.total = currentTotal;
                data.data.forEach((item) => {
                    this.data.push(item);
                });

                this.loading = false;
            }).catch(err => {
                this.data = [];
                this.total = 0;
                this.loading = false;
                throw err;
            });

        },

        onPageChange(page) {
            this.page = page;
            this.loadAsyncData();
        },

        onSort(field, order) {
            this.sortfield = field;
            this.sortOrder = order;
            this.loadAsyncData();
        },

        setPerPage() {
            this.loadAsyncData();
        },

        openModal(){
             this.loadAsyncData();
             this.isModalActive = true;
        },

        selectData(dataRow){
            this.isModalActive = false;
            this.$emit('browseSubjects', dataRow);
        },

       


    },

    mounted(){
        this.loadAsyncData()
    },

    computed: {
        valueFullname(){
            return this.propName;
        }
    },

}
</script>

<style scoped>
    .card-width{
        width: 640px;
    }
</style>
