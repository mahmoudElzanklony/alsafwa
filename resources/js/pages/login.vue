<template>
    <div class="form-outer">
        <form class="form_icons" name="auth" method="post" @submit.prevent="signin">
            <h2 class="txt-shadow text-center mb-4">تسجيل الدخول</h2>
            <p name="error_message" class="alert alert-danger"></p>
            <div class="form-group">
                <label>البريد الالكتروني</label>
                <input class="form-control" name="email" type="email" required>
                <span><i class="ri-mail-line"></i></span>
                <p class="alert alert-danger"></p>
            </div>
            <div class="form-group">
                <label>كلمه المرور</label>
                <input class="form-control" type="password" name="password" required>
                <span><i class="ri-lock-password-line"></i></span>
                <p class="alert alert-danger"></p>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="تسجيل الدخول">
            </div>
        </form>
    </div>
</template>

<script>
import errorAjax from "../mixin/errorAjax";

export default {
    name: "login",
    mixins:[errorAjax],
    methods:{
        signin:function (){
          var target = $(event.target);
          target.find('p.alert-danger').hide();
          $.ajax({
              url:'/login',
              type:'POST',
              data:{email:document.auth.email.value , password:document.auth.password.value},
              dataType:'JSON',
              success:function (data){
                  this.handleErrorAjax(data,target)
                  if (data.hasOwnProperty('success')){
                      // he is logined
                      // stored data at local storage
                      localStorage.setItem('user',JSON.stringify(data.success[0]));

                      this.$inertia.visit('/');
                  }
              }.bind(this),
              error:function(){
                 // window.location = document.URL;
              }
          });
        },
    },
    created() {
        document.body.style.zoom = "100%";
    },
}
</script>

<style lang="scss" scoped>
@import "resources/scss/style";
.form-outer{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #e3f2fd;
    text-align: right;
    flex-wrap: wrap;
    form{
        max-width: 400px;
        width: 400px;
        .alert-danger{
            display: none;
        }
    }
}
</style>
