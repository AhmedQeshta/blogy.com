<template>
    <div>
        <nav class="navbar navbar-light justify-content-center">
            <a class="navbar-brand mr-0" href="#">Admin</a>
        </nav>

        <section>
            <div class="container">
                <div class="row justify-content-center">
                    <form class="col-md-5 col-lg-4" @submit.prevent="loginAsAdmin">
                        <div class="form-group bmd-form-group">
                            <label class="bmd-label-floating" for="input1-signin-02">Email</label>
                            <input id="input1-signin-02" v-model.trim="form.email" class="form-control" required
                                   type="email">
                        </div>
                        <div class="form-group bmd-form-group">
                            <label class="bmd-label-floating" for="input3-signin-02">Password</label>
                            <input id="input3-signin-02" v-model.trim="form.password" class="form-control" required
                                   type="password">
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-primary btn-raised btn-block mb-2 mr-3" type="submit">Sign In!
                            </button>

                        </div>
                        <p class="text-secondary text-muted mt-3">By signing in you agree with the <a href="#">Terms and
                            Conditions</a> and <a href="#">Privacy Policy</a>.</p>
                    </form>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
export default {
    name: "LoginAsAdmin",
    data() {
        return {
            form: {
                email: null,
                password: null,
            },
            errors: null,
        }
    },
    methods: {
        async loginAsAdmin() {
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
                let response = await axios.post('/api/admin/login', this.$data.form);
                localStorage.setItem('token', response.data.access_token);
                localStorage.setItem('token_type', response.data.token_type);
                await this.$store.dispatch('admin', response.data);
                await this.$router.push({path: '/admin/dashboard'});
                this.$data.form = {};
            } catch (e) {
                this.errors = 'Invalid Email/Password';
                setTimeout(() => {
                    this.errors = null;
                }, 3000);
                return false;
            }
        }
    }
}
</script>

<style scoped>

</style>
