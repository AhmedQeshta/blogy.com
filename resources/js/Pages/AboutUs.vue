<template>
    <div>
        <navBar/>
        <section class="py-5">
            <div class="container text-center">
                <h2 class="mb-5">Learn more about PiperNet</h2>
                <div class="card-deck">
                    <div class="card">
                        <div class="card-body mt-3">
                            <h5 class="card-title">Videos</h5>
                            <p class="card-text">Stop watching boring YouTube videos, and check out Dinesh's extremely
                                interesting series about the features of PiperNet.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 mb-3"><a class="btn btn-primary" href="#">Watch
                            Now</a></div>
                    </div>
                    <div class="card">
                        <div class="card-body mt-3">
                            <h5 class="card-title">Articles</h5>
                            <p class="card-text">Let Gilfoyle take you on a journey into the futuristic world of
                                computing and data security in the decentralized age.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 mb-3"><a class="btn btn-primary" href="#">Read
                            Now</a></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <div class="container text-center">
                <a href="#"><img alt="" height="100" src="placeholder/pictures/bg_square.svg?primary=009688"></a>
                <h2 class="my-4">Learn more about PiperNet</h2>
                <p>Our mission is not to outsell Hooli with a product like their latest Box 3. We are not in it for the
                    money - we are in it to make the whole world decentralized. To give you control over your data. To
                    change by the internet as we know it by integrating a very important feature into it - freedom.</p>
            </div>
        </section>
        <Footer/>
    </div>
</template>

<script>
import NavBar from "../components/navBar";
import Footer from "../components/Footer";

export default {
    name: "AboutUs",
    components: {Footer, NavBar}
}
</script>

<style scoped>

</style>
