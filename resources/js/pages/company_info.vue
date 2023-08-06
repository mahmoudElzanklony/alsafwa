<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه معلومات المكتب </h2>
            <div class="form-data">
                <div class="container">
                    <form class="form_icons mt-3" method="post" @submit.prevent="saveData">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group text-right">
                                    <label>اسم المكتب</label>
                                    <input class="form-control" name="name"
                                           :value="data.name"
                                           required>
                                    <span><i class="ri-information-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-right">
                                    <label>البريد الالكتروني</label>
                                    <input class="form-control" name="email" type="email"
                                           :value="data.email"
                                           required>
                                    <span><i class="ri-mail-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-right">
                                    <label>العنوان</label>
                                    <input class="form-control" name="address"
                                           :value="data.address"
                                           required>
                                    <span><i class="ri-map-pin-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-right">
                                    <label>رقم الهاتف</label>
                                    <input class="form-control" name="phone"
                                           :value="data.phone"
                                           required>
                                    <span><i class="ri-phone-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <label>الجمله الترحيبيه</label>
                                    <input class="form-control"  name="receipt_sentence" autocomplete="off" :value="data.receipt_sentence">
                                    <span><i class="ri-hand-heart-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-right">
                                    <label>صوره اللوجو</label>
                                    <input class="form-control" name="image" type="file">
                                    <span><i class="ri-image-line"></i></span>
                                    <p class="alert alert-danger"></p>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary form-control mt-2" value="حفظ">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavbarComponent from "../components/navbar-component";
import errorAjax from "../mixin/errorAjax";
export default {
    name: "company_info",
    components: {NavbarComponent},
    props:['data'],
    mixins:[errorAjax],
    mounted() {

    },
    methods:{
        saveData:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);
            form_data.append('id',this.data.id);
            $.ajax({
                url:'/companyinfo/save',
                type:'POST',
                data:form_data,
                processData: false,
                contentType: false,
                success:function (data){
                    this.handleErrorAjax(data,target);
                    if(data.hasOwnProperty('success')){
                        Toast.fire({
                            icon: 'success',
                            title: 'تمت عمليه الحفظ بنجاح'
                        });
                        setTimeout(function (){
                            window.location = document.URL;
                        },1000);
                    }

                }.bind(this)
            });
        }
    }
}
</script>

<style lang="scss" scoped>
.alert-danger{
    display: none;
}
</style>
