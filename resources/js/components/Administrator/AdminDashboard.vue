<template>
    <div>
        <div class="container">

            <div class="dashboard-section">
                <div class="card p-4">
                    <div class="subtitle">TOTAL NO. OF ENROLMENT</div>
                    <div class="mt-5 title" v-if="info">{{ info.toLocaleString() }}</div>
                    <div class="mt-5 title" v-else>...</div>
                </div>

                <div class="card p-4">
                    <div class="subtitle">TOTAL REGISTERED LEARNERS</div>
                    <div class="mt-5 title" v-if="registered">{{ registered.toLocaleString() }}</div>
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
            registered: null,

		}
	},

	methods:{
        loadCountEnrolls(){
            axios.get('/count-enrolls').then(res=>{
                this.info = res.data
            }).catch(err=>{
            
            })
        },

        loanCountRegistered(){
            axios.get('/count-registered').then(res=>{
                this.registered = res.data
            }).catch(err=>{
            
            })
        }
	},

    mounted() {
        this.loadCountEnrolls()
        this.loanCountRegistered()
    }
}
</script>

<style scoped>

.container{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 300px;
}
.dashboard-section {
    display: flex;
    gap: 20px;
}
</style>
