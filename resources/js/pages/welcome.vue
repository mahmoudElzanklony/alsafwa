<template>
    <div>
        <navbar-component></navbar-component>
        <form style="display: none" action="/"  enctype="multipart/form-data" >
            <input type="file" name="file">
            <input type="text" name="username">
            <input type="text" name="email">
            <input type="submit" value="send">
        </form>
        <div class="page-content">
            <div data-v-cdd8e9ee="" class="text-center company_logo">
                <img src="/images/logo_2.png" class="d-block m-auto">
            </div>


            <div class="container mt-5">
                <div class="row mb-4 align-items-center">
                    <div class="col-lg-3 col-md-6 mb-2">
                        <a href="/info-data?status=0" class="mb-4">
                            <div class="box-statics text-center green">
                                <span><i class="ri-file-info-line"></i></span>
                                <p>عدد البيانات</p>
                                <p>{{ info_data }}</p>
                            </div>
                        </a>
                        <a href="/users" class="mb-4">
                            <div class="box-statics text-center red">
                                <span><i class="ri-group-line"></i></span>
                                <p> المستخدمين</p>
                                <p>{{ employees }}</p>
                            </div>
                        </a>
                        <a href="/companies-branches">
                            <div class="box-statics text-center blue">
                                <span><i class="ri-stack-line"></i></span>
                                <p>الأفرع</p>
                                <p>{{ companies }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-2">
                        <a href="/reports" class="mb-4 reports d-block m-auto">
                            <div class="box-statics text-center gray">
                                <span><i class="ri-file-list-3-line"></i></span>
                                <p>التقارير</p>
                                <p>{{ reports }}</p>
                            </div>
                        </a>
                        <img src="/images/whatbar.jpg" class="w-100 mb-4">
                        <a href="/deletes" class="d-block m-auto">
                            <div class="box-statics text-center red">
                                <span>
                                    <i class="ri-delete-bin-5-line"></i>
                                </span>
                                <p>المحذوفات</p>
                                <p></p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <a href="/info-data?status=1" class="mb-4">
                            <div class="box-statics text-center red">
                                <span><i class="ri-briefcase-line"></i></span>
                                <p>عدد المشاريع الناجحه</p>
                                <p>2840</p>
                            </div>
                        </a>
                        <div class="box-statics text-center red mb-4">
                            <span><i class="ri-macbook-line"></i></span>
                            <p>اجتماعات عبر الانترنت</p>
                            <p ></p>
                        </div>
                        <div class="box-statics text-center red mb-4">
                            <span>
                                <i class="ri-customer-service-2-line"></i>
                            </span>
                            <p>دعم فني</p>
                            <p>22/7</p>
                        </div>
                    </div> <!----> <!----> <!----> <!---->
                </div>
            </div>


            <div class="location">
                <div class="container">
                    <div class="row align-items-center">
                        <div  class="col-md-6 col-12 text-right">
                            <p>
                                <span>
                                    <i class="ri-map-pin-line"></i>
                                </span>
                                <span>دمياط ميناء دمياط مبنى خدمه العملاء الدور الثانى مكتب 211B</span>
                            </p>
                            <p>
                                <span>
                                    <i class="ri-map-pin-line"></i>
                                </span>
                                <span>دمياط دمياط الجديدة المركزية شارع  العيون الدولى</span>
                            </p>
                            <p class="d-flex">
                                <span><i class="ri-smartphone-line"></i></span>
                                <span>01004468633</span>
                            </p>
                            <p class="d-flex">
                                <span><i  class="ri-phone-line"></i></span>
                                <span>0572433399</span>
                            </p>
                        </div>
                        <div class="col-lg-6 col-12 mb-2">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3404.197959748356!2d31.676302984851358!3d31.436216681397465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMzHCsDI2JzEwLjQiTiAzMcKwNDAnMjYuOCJF!5e0!3m2!1sar!2seg!4v1691590130026!5m2!1sar!2seg" width="100%"
                                    height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-content" v-if="false">
            <h2 class="main-title">مرحبا بك في صفحه احصائيات الاداره</h2>
            <div class="container mt-5">
                <div class="row mb-4">
                    <div class="col-lg-4 col-md-6 mb-2" v-if="$page.props.user_personal_data.type == 'admin'">
                        <inertia-link href="/users">
                            <div class="box-statics text-center red">
                                <p>عدد المستخدمين</p>
                                <p>{{ employees }}</p>
                            </div>
                        </inertia-link>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2" v-if="$page.props.user_personal_data.type == 'admin'">
                        <inertia-link href="/companies-branches">
                            <div class="box-statics text-center blue">
                                <p>عدد الأفرع</p>
                                <p>{{ companies }}</p>
                            </div>
                        </inertia-link>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <inertia-link href="/info-data?status=0">
                            <div class="box-statics text-center green">
                                <p v-if="$page.props.user_personal_data.type == 'admin'">عدد البيانات</p>
                                <p v-if="$page.props.user_personal_data.type != 'admin'">البيانات</p>
                                <p v-if="$page.props.user_personal_data.type == 'admin'">{{ info_data }}</p>
                            </div>
                        </inertia-link>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2" v-if="$page.props.user_personal_data.type == 'admin'">
                        <inertia-link href="/reports">
                            <div class="box-statics text-center gray">
                                <p>التقارير</p>
                                <p>{{ reports }}</p>
                            </div>
                        </inertia-link>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2" v-if="$page.props.user_personal_data.type == 'admin'">
                        <inertia-link href="/deletes">
                            <div class="box-statics text-center red">
                                <p>المحذوفات</p>
                                <p></p>
                            </div>
                        </inertia-link>
                    </div>
                </div>
                <table v-if="$page.props.user_personal_data.type == 'admin'" class="table table-hover text-center w-100 table-striped table-bordered">
                    <tr>
                        <td>النوع</td>
                        <td>العدد</td>
                    </tr>
                    <tr>
                        <td>عدد المستخدمين</td>
                        <td>{{ employees }}</td>
                    </tr>
                    <tr>
                        <td>عدد الأفرع</td>
                        <td>{{ companies }}</td>
                    </tr>
                    <tr>
                        <td>عدد البيانات</td>
                        <td>{{ info_data }}</td>
                    </tr>
                    <tr>
                        <td>عدد التقارير</td>
                        <td>{{ reports }}</td>
                    </tr>
                </table>
            </div>
        </div>

            <div class="social">
                <ul>
                    <li>
                        <a href="#" target="_blank">
                            <span><i class="ri-facebook-line"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank">
                            <span>
                                <i class="ri-instagram-line"></i>
                            </span>
                        </a>
                    </li>
                    <li >
                        <a href="#" target="_blank"><span ><i class="ri-twitter-line"></i></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import NavbarComponent from "../components/navbar-component";
export default {
    name: "welcome",
    props:['companies','employees','info_data','reports'],
    methods:{
        upload:function(){
            var target = event.target;
            var data = new FormData(target);
            axios.post('/upload',data).then((e)=>{
                console.log(e);
            }).catch((e)=>{
                console.log(e);
            })
        }
    },
    created() {
        document.body.style.zoom = "100%";
    },

    components: {NavbarComponent}
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
        background-color: #7086fa30 !important;
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
