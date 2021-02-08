<template>
    <div class="body-newLogin">
        <NavBar/>
        <section class="py-5">
            <div class="container">

                <form action="#" class="row justify-content-between" @submit.prevent="loginForm">
                    <div class="col-md-5">
                        <h3>Sign in to the PiperNet</h3>
                        <div class="form-group bmd-form-group is-filled">
                            <label class="bmd-label-floating" for="input1-signin-04">Email</label>
                            <input id="input1-signin-04" v-model.trim="form.email" class="form-control" required
                                   type="email">
                        </div>
                        <div class="form-group bmd-form-group is-filled">
                            <label class="bmd-label-floating" for="input2-signin-04">Password</label>
                            <input id="input2-signin-04" v-model.trim="form.password" class="form-control" required
                                   type="password">
                        </div>
                        <p> {{ this.errors }}</p>
                        <button class="btn btn-primary btn-block btn-raised" type="submit">Sign In!</button>
                    </div>
                </form>

            </div>
        </section>
        <Footer/>
    </div>
</template>

<script>
import NavBar from "../components/navBar";
import Footer from "../components/Footer";

export default {
    name: "Login",
    data() {
        return {
            form: {
                email: null,
                password: null,
            },
            errors: null
        }
    },
    methods: {
        async loginForm() {
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
                let response = await axios.post('/api/login', this.$data.form);
                localStorage.setItem('token', response.data.access_token);
                localStorage.setItem('token_type', response.data.token_type);
                await this.$store.dispatch('user', response.data);
                await this.$router.push({path: '/dashboard'});
                this.$data.form = {};
            } catch (e) {
                this.errors = 'Invalid Email/Password';
                setTimeout(() => {
                    this.errors = null;
                }, 3000);
                return false;
            }

        }
    },
    components: {Footer, NavBar}
}
</script>

<style scoped>
.body-newLogin {
    display: flex;
    flex-direction: column;
    justify-content: center;
    justify-items: center;
}
</style>
