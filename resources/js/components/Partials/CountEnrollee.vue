<template>
    <div class="card">
        <div class="subtitle">TOTAL NO. OF ENROLMENT</div>
        <div class="mt-5 title" v-if="info">{{ info.toLocaleString() }}</div>
        <div class="mt-5 title" v-else>...</div>
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

<style scoped>

</style>
