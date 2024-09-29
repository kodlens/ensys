<template>
    <div class="login-wrapper">
        <form @submit.prevent="submit">
            <div class="box">
                <div class="title is-4 is-centered">
                    SIGN IN
                </div>
                <hr class="hr-line">

                <div class="panel-body">
                    <b-field class="login-input" label="Username" label-position="on-border"
                        :type="this.errors.username ? 'is-danger':''"
                        :message="this.errors.username ? this.errors.username[0] : ''">
                        <b-input type="text" icon="account" v-model="fields.username" placeholder="Username" />
                    </b-field>

                    <b-field label="Password" label-position="on-border">
                        <b-input type="password" icon="lock" v-model="fields.password" password-reveal placeholder="Password" />
                    </b-field>

                    <div class="buttons is-centered mt-4">
                        <button 
                            tag="button" 
                            :class="btnClass">
                            LOGIN
                            <b-icon class="ml-2" icon="arrow-right"></b-icon>
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</template>

<script>

export default {
    data(){
        return {
            fields: {
                username: null,
                password: null,
            },

            btnClass: {
                'button': true,
                'is-primary':true,
                'is-loading':false,
            },

            loading: false,

            errors: {},
        }
    },

    methods: {
        submit: function(){
            this.btnClass['is-loading'] = true
            axios.post('/login', this.fields).then(res=>{
                //console.log(res.data)
            this.btnClass['is-loading'] = false

                if(res.data){
                    window.location = '/login'
                }
              

               //window.location = '/dashboard';
            }).catch(err=>{
                this.btnClass['is-loading'] = false
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }

                this.clearFields()
            });
        },

        clearFields(){
            this.fields.username = ''
            this.fields.password = ''
        }
    }
}
</script>


<style scoped src="../../css/login.css"></style>
