<template>
    <div>
        <navbar-component></navbar-component>
        <div class="page-content">
            <h2 class="main-title">مرحبا بك في صفحه اجمالي الحسابات </h2>
            <div class="container mt-5">
                <form @submit.prevent="filterData" class="d-flex justify-content-center align-items-center">
                    <input class="form-control" type="date" name="start" required>
                    <input class="form-control" type="date" name="end" required>
                    <input class="form-control btn btn-primary" type="submit" value="بحث">
                </form>
                <table class="table table-bordered  table-hover text-center table-striped">
                    <thead>
                    <tr>
                        <td> اجمالي عدد الخدمات</td>
                        <td>اجمالي سعر الخدمات</td>
                        <td>اجمالي مصروفات الخدمات</td>
                        <td>اجمالي ربح الخدمات</td>
                        <td>اجمالي ديون العملاء</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ output.total_requests }}</td>
                            <td>{{ total_prices_of_services }}</td>
                            <td>{{ output.total_costs }}</td>
                            <td>{{ output.total_taken }}</td>
                            <td>{{ Number(total_prices_of_services) -  Number(output.total_taken) }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>


        </div>
    </div>
</template>


<script>
import NavbarComponent from "../components/navbar-component";
export default {
    name: "filter_count_data",
    props:['total_services_prices','data'],
    components: {NavbarComponent},
    data:function(){
        return {
            output:this.data,
            total_prices_of_services:this.total_services_prices,
        }
    },
    methods:{

        filterData:function (){
            var target = $(event.target);
            var form_data = new FormData(event.target);

            $.ajax({
                url:'/all-statics/filter',
                type:'POST',
                data:form_data,
                processData: false,
                contentType: false,
                success:function (data){
                    console.log(data);
                    this.output = data.data;
                    this.total_prices_of_services = data.total_services_prices;
                }.bind(this)
            });
        }

    }
}
</script>

<style lang="scss" scoped>
form{
    max-width: 500px;
    margin: 20px auto;
    input:not(:last-of-type){
        margin-left: 10px;
    }
}
</style>
