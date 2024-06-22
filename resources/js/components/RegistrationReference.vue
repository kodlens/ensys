<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6">

                    <div class="box">
                        <h1 class="subtitle has-text-weight-bold">
                            YOUR REFERENCE NO.
                        </h1>
                        <h1 class="title p-4">
                             {{propRef}}
                        </h1>

                        <div>
                            Please save this reference number for your records; it will be used during the enrollment process.
                        </div>

                        <div class="buttons mt-2">
                            <b-button type="is-info" label="HOME"
                                tag="a" href="/"></b-button>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>

export default{
    props: {
        propRef: {
            type: String,
            default: ''
        }
    },
    data(){
        return {
        }
    },

    methods: {

    },

    mounted(){

    }
}
</script>