<template>
    <div>
        <div class="welcome-container">

            <div class="section">
                <div class="card p-4">
                    <div class="subtitle">TOTAL NO. OF ENROLMENT</div>
                    <div class="mt-5 title" v-if="info">{{ info.toLocaleString() }}</div>
                    <div class="mt-5 title" v-else>...</div>
                </div>
            </div>
            <!-- <div class="logo-wrapper">
                <img src="/img/tcnhs_logo.png" class="tcnhs-logo" alt="TCNHS Logo">
            </div>
           
            <div class="loader-3">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div>

            <div class="welcome-text">
                WELCOME ADMINISTRATOR
            </div> -->
            
        </div>
    </div>
</template>

<script>
export default {
	data(){
		return{
            info: null,

		}
	},

	methods:{
        loadCountEnrolls(){
            axios.get('/count-enrolls').then(res=>{
                this.info = res.data
            }).catch(err=>{
            
            })
        }
	},

    mounted() {
        this.loadCountEnrolls()
    }
}
</script>

<style scoped src="../../../css/admin-home.css">
</style>
