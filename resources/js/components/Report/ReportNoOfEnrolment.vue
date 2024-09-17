<template>
    <div>
        <div class="columns">
            <div class="column">
                <div>
                    No of enrolment
                </div>
            </div>
             
        </div>
        
    </div>
</template>

<script>
export default {
    data() {
        return {
            enrolment: {}
        }
    },
    method: {
        loadEnrolment(){
            axios.get('/get-report-no-of-enrolment').then(res=>{
                this.enrolment = res.data
            })
        }
    },

    mounted() {
        this.loadEnrolment()
    }
}
</script>

<style scoped>

</style>