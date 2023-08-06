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
