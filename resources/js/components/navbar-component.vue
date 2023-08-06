<template>

    <div class="outer-nav">
        <span><i class="ri-menu-3-line"></i></span>
        <nav>
        <img :src="'/images/logo.png'">
            <h2 class="text-center">

        </h2>
        <ul>
            <li>
                <a href="/" >
                    <span><i class="ri-home-3-line"></i></span>
                    <span>الرئيسيه</span>
                </a>
            </li>


            <li v-if="$page.props.user_personal_data.type == 'admin'">
                <a href="/charts">
                    <span><i class="ri-line-chart-line"></i></span>
                    <span>احصائيات بيانيه</span>
                </a>
            </li>
            <li >
                <a href="/info-data?status=0">
                    <span><i class="ri-information-line"></i></span>
                    <span>البيانات</span>
                </a>
            </li>
            <li v-if="$page.props.user_personal_data.type == 'admin'">
                <a href="/companies-branches">
                    <span><i class="ri-list-check"></i></span>
                    <span>الشركات</span>
                </a>
            </li>
            <li v-if="$page.props.user_personal_data.type == 'admin'">
                <a href="/reports">
                    <span><i class="ri-file-line"></i></span>
                    <span>تقارير المستخدمين</span>
                </a>
            </li>
            <li v-if="$page.props.user_personal_data.type == 'admin'">
                <a href="/users" >
                    <span><i class="ri-user-3-line"></i></span>
                    <span>المستخدمين</span>
                </a>
            </li>
            <li v-if="$page.props.user_personal_data.type == 'admin'">
                <a href="/exporters" >
                    <span><i class="ri-group-line"></i></span>
                    <span>المصدرين</span>
                </a>
            </li>
            <li v-if="$page.props.user_personal_data.type == 'admin'">
                <a href="/destinations" >
                    <span><i class="ri-road-map-line"></i></span>
                    <span>الوجهات</span>
                </a>
            </li>
            <li v-if="$page.props.user_personal_data.type == 'admin'">
                <a href="/countries" >
                    <span><i class="ri-map-pin-line"></i></span>
                    <span>المناشئ</span>
                </a>
            </li>
            <li v-if="$page.props.user_personal_data.type == 'admin'">
                <a href="deletes">
                    <span><i class="ri-delete-bin-line"></i></span>
                    <span>المحذوفات</span>
                </a>
            </li>

            <li>
                <a href="/logout">
                    <span><i class="ri-logout-box-r-line"></i></span>
                    <span>تسجيل خروج</span>
                </a>
            </li>



        </ul>
    </nav>
    </div>

</template>

<script>

export default {
    name: "navbar-component",
    data:function (){
        return {
            user:null,
            actions_types:['التقنين','ترخيص','ترخيص محلات','تصميم داخلي'],
        }
    },
    created() {
        if(localStorage.getItem('user')){
            this.user = JSON.parse(localStorage.getItem('user'));
        }
    }
}
</script>

<style lang="scss" scoped>
@import "resources/scss/style";
.outer-nav{
    >span{
        position: fixed;
        right: 10px;
        top: 10px;
        font-size: $medium;
        color: $black;
        z-index: 99999999999;
    }
}
nav{
    width: 200px;
    position: fixed;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 9999;
    background-color: $blue;
    overflow: hidden;
    >img{
        display: block;
        margin: 20px auto;
        max-width: 100px;
    }

    h2{
        font-size: $medium;
    }
    h3{
        font-size: $small;
    }

    >ul{
        >li{
            &:hover{
                background-color: $dark_blue;
                padding-right: 30px;
            }
        }
    }
    ul{
        overflow: auto;
        height: calc(100% - 153px);
        li{
            border-bottom: 1px solid #ddd;
            text-align: right;
            padding: 10px;
            transition: 0.5s all;

            a{
                font-size: $normal;
                color: white;
                text-decoration: none;
                span:first-of-type{
                    position: relative;
                    top: 4px;
                    margin-left: 2px;
                }
            }
        }
    }
    .list_data{
        padding: 0px;
        p , li{
            padding: 10px;
        }
        li{
            &:hover{
                background-color: $dark_blue;
                padding-right: 30px;
            }
        }
        ul{
            display: none;
        }
        p{
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0px;
            span{
                color:white;
            }
            span:first-of-type{
                color:$black;
                font-weight: bold;
                font-size: 20px;
            }

        }
    }
}
</style>
