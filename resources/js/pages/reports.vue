<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه تقارير المستخدمين </h2>
            <div class="container mt-5">
                <table class="myTable table table-bordered  table-hover text-center table-striped">
                    <thead>
                    <tr>
                        <td>الرقم التسلسلي</td>
                        <td>اسم المستخدم</td>
                        <td>العملية</td>
                        <td>التاريخ</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in output" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.user.name }}</td>
                        <td>{{ item.content }}</td>
                        <td>{{ new Date(item.created_at).toLocaleString() }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>

<script>
import NavbarComponent from "../components/navbar-component";
import tableData from "../mixin/tableData";

export default {
    name: "users_data",
    mixins:[tableData,tableData],
    components: {NavbarComponent},
    props:['data'],
    data:function (){
        return{
            item:null,
            output:this.data,
        }
    },
    methods:{

    },
    created() {
        document.body.style.zoom = "100%";
    },

}
</script>

<style lang="scss" scoped>
.modal.show .modal-dialog{
    max-width: 55%;
}
input[type="checkbox"]{
    position: relative;
    top: 3px;
    width: 15px;
    height: 15px;
}
table span[name='privillage']{
    padding: 5px 20px;
    border-radius: 10px;
    margin-left: 5px;
    display: inline-block;
    margin-bottom: 5px;
}
</style>
