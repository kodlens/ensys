<template>
    <div class="section">

        <div class="columns is-centered">
            <div class="column is-6-widescreen is-8-desktop">

                <div class="box">
                    <div>UPDATE ENROLMENT STATUS</div>
                    <hr>

                    <div class="columns">
                        <div class="column">
                            <b-field label="Select Status"
                                expanded
                                :type="errors.status ? 'is-danger':''"
                                :message="errors.status ? errors.status[0] : ''">
                                <b-select v-model="fields.status" expanded>
                                    <option value="WITHDRAWN">WITHDRAW</option>
                                    <option value="DROPPED">DROP</option>
                                    <option value="TRANSFERED">TRANSFER</option>
                                </b-select>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <b-field label="Date"
                                expanded
                                :type="errors.date_transfered ? 'is-danger':''"
                                :message="errors.date_transfered ? errors.date_transfered[0] : ''">
                                <b-datepicker v-model="fields.date_transfered" expanded></b-datepicker>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <b-field label="Reason"
                                expanded
                                :type="errors.reason ? 'is-danger':''"
                                :message="errors.reason ? errors.reason[0] : ''">
                                <b-input type="textarea" v-model="fields.reason" expanded></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns" v-if="fields.status === 'TRANSFER'">
                        <div class="column">
                            <b-field label="If Transfer (Name of the school)"
                                expanded
                                :type="errors.school_transfered ? 'is-danger':''"
                                :message="errors.school_transfered ? errors.school_transfered[0] : ''">
                                <b-input type="text" v-model="fields.school_transfered" expanded></b-input>
                            </b-field>
                        </div>
                    </div>

                    <div class="buttons mt-2">
                        <b-button 
                            type="is-primary" 
                            label="SAVE" icon-right="content-save-check-outline"
                            @click="submit"></b-button>
                    </div>

                </div>

            </div>
        </div>
        
    </div> <!--section (root)-->
</template>

<script>

export default {
    props: {
        propId: {
            type: Number,
            default: 0
        },
        propData: {
            type: Object,
            default: ()=>{}
        }
    },

    data(){
        return {
            fields: {
                status: 'TRANSFER',
                date_transfered: new Date(),
                reason: '',
                school_transfered: ''
            },
            errors: {}
        }
    },

    methods: {
        submit(){
            axios.post('/enrollee-update-status/' + this.propId, this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: 'Saved!',
                        message: 'Status saved successfully.',
                        type: 'is-success',
                        onConfirm: ()=>[ 
                            window.location = '/enrollee'
                        ]
                    })
                }
            }).catch(err=>{
            
            })
        }
    },

    mounted(){
        if(this.propData){
            this.fields = this.propData
        }
    }
}
</script>