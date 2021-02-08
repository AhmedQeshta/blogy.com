<template>
    <div>
        <NavBar/>
        <div class="container">
            <div class="card mt-5">
                <div class="card-header bg-secondary text-white text-center w-100">
                    <h3>Register</h3>
                </div>
                <div class="card-body">
                    <section>
                        <div class="container">
                            <form action="#" class="row justify-content-center" @submit.prevent="RegisterForm">
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="input1-signin-03">Name</label>
                                        <input id="input1-signin-03" v-model.trim="form.name" class="form-control"
                                               required type="text">
                                    </div>
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="input2-signin-03">Email</label>
                                        <input id="input2-signin-03" v-model.trim="form.email" class="form-control"
                                               required type="email">
                                    </div>
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="input3-signin-03">Password</label>
                                        <input id="input3-signin-03" v-model.trim="form.password" class="form-control"
                                               required type="password">
                                    </div>
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating" for="input4-signin-03">Repeat password</label>
                                        <input id="input4-signin-03" v-model.trim="form.password_confirmation"
                                               class="form-control"
                                               required type="password">
                                    </div>

                                    <button class="btn btn-success btn-block btn-raised py-2 my-5" type="submit">Sign
                                        up
                                    </button>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import NavBar from "../components/navBar";


export default {
    name: "Register",
    components: {NavBar},
    data() {
        return {
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
            errors: null
        }
    },
    methods: {
        async RegisterForm() {
            let userEmail = this.$data.form.email;
            let EmailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            let CheckEmail = EmailRegex.test(userEmail);//true or false
            if (!CheckEmail) {
                this.errors = "Sorry! Email Faild, must be (@) and (.) and ignored space";
                setTimeout(() => {
                    this.errors = null;
                }, 3000);
                return false;
            }
            try {
                console.log("this.$data.form")
                await axios.post('/api/register', this.$data.form);
                console.log("res1")
                let res = await axios.post('/api/login', {
                    email: this.$data.form.email,
                    password: this.$data.form.password
                });
                console.log("res")
                localStorage.setItem('token', res.data.access_token);
                localStorage.setItem('token_type', res.data.token_type);
                await this.$store.dispatch('user', res.data);
                await this.$router.push({path: '/dashboard'});
            } catch (e) {
                this.errors = 'Invalid data';
                setTimeout(() => {
                    this.errors = null;
                }, 3000);
                return false;
            }
            this.$data.form = {};
        }
    },
}
</script>

<style scoped>

</style>
