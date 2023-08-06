<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه المحذوفات</h2>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-2">
                        <inertia-link href="?type=users">
                            <div class="box-statics text-center red">
                                <p>عدد المستخدمين</p>
                                <p>{{ employees }}</p>
                            </div>
                        </inertia-link>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <inertia-link href="?type=branches">
                            <div class="box-statics text-center blue">
                                <p>عدد الشركات</p>
                                <p>{{ companies }}</p>
                            </div>
                        </inertia-link>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <inertia-link href="?type=info">
                            <div class="box-statics text-center green">
                                <p>عدد البيانات</p>
                                <p>{{ info_data }}</p>
                            </div>
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavbarComponent from "../components/navbar-component";

export default {
    name: "welcome",
    props: ['companies', 'employees', 'info_data'],
    components: {NavbarComponent},
    created() {
        this.type = document.URL.split('type=')[1];
        document.body.style.zoom = "100%";
    },
}
</script>


<style lang="scss" scoped>
@import "resources/scss/variables";
a{
    text-decoration: none;
}
.blue{
    background-color: #e3f2fd;
}
.red{
    background-color: #ffebee;
}
.green{
    background-color: #e8f5e9;
}
.gray{
    background-color:#fafafa;
}
.purple{
    background-color: #f3e5f5;
}
.yellow{
    background-color: #fffde7;
}
.box-statics{
    height: 150px;
    border: 1px solid #ddd;
    border-radius: 15px;
    display: flex;
    align-items: center;
    align-content: center;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 10px;
    p{
        width: 100%;
        margin:0px;
        color: $black;
        font-size: $normal;
    }
    p:last-of-type{
        font-size: $medium;
        font-weight: bold;
    }
}
</style>
