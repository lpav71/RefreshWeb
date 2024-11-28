<template>
    <div class="login-main">
        <div class="login-window">
            <img alt="Logo" src="images/logo.png"/>
            <div class="form-control form-login">

                <div class="row mb-3">
                    <div v-if="errorEmail" class="info" style="color: red">E-mail {{ $props.email }} уже зарегистрирован</div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end" for="phone">Номер телефона</label>
                    <div class="col-md-6">
                        <input id="phone" v-model="phone" class="form-control" type="text">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end" for="login">Логин*</label>
                    <div class="col-md-6">
                        <input id="login" v-model="login" class="form-control" type="text">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end" for="lastName">Фамилия</label>
                    <div class="col-md-6">
                        <input id="lastName" v-model="lastName" class="form-control" type="text">
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end" for="firstName">Имя</label>
                    <div class="col-md-6">
                        <input id="firstName" v-model="firstName" class="form-control" type="text">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end" for="middleName">Отчество</label>
                    <div class="col-md-6">
                        <input id="middleName" v-model="middleName" class="form-control" type="text">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end" for="pass1">Введите пароль*</label>
                    <div class="col-md-6">
                        <input id="pass1" v-model="pass1" class="form-control" type="password">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end" for="pass2">Повторите пароль*</label>
                    <div class="col-md-6">
                        <input id="pass2" v-model="pass2" class="form-control" type="password">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="info">* - обязательные поля</div>
                </div>

                <div style="display: flex;justify-content: center;">
                    <button v-if="!errorEmail" class="btn btn-success" type="submit" @click="register">
                        Зарегистрироваться
                    </button>
                </div>
            </div>
        </div>
    </div>

    <message ref="message"></message>

</template>

<script>

export default {
    name : "Registration",
    props: ['club_id', 'email', 'user_id'],
    data() {
        return {
            phone     : '',
            login     : '',
            lastName  : '', //Фамилия
            firstName : '', //Имя
            middleName: '', //Отчество
            birthDate : '', //Дата рождения
            pass1     : '',
            pass2     : '',
            errorEmail: false
        }
    },
    methods: {
        async verify() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("email", this.$props.email);

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/user/verify", requestOptions);
            if (!response.ok) {
                this.errorEmail = true;
            }
        },
        async register() {
            if (this.pass1 === this.pass2) {
                var myHeaders = new Headers();
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

                var urlencoded = new URLSearchParams();
                urlencoded.append("email", this.$props.email);
                urlencoded.append("id_user_setting", this.$props.user_id);
                urlencoded.append("club_id", this.$props.club_id);
                urlencoded.append("login", this.login);
                urlencoded.append("lastName", this.lastName);
                urlencoded.append("firstName", this.firstName);
                urlencoded.append("middleName", this.middleName);
                urlencoded.append("birthDate", this.birthDate);
                urlencoded.append("pass1", this.pass1);

                var requestOptions = {
                    method  : 'POST',
                    headers : myHeaders,
                    body    : urlencoded,
                    redirect: 'follow'
                };

                var response = await fetch("api/user/registration", requestOptions);
                if (response.ok) {
                    var token      = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var myHeaders2 = new Headers();
                    myHeaders2.append("Content-Type", "application/x-www-form-urlencoded");
                    myHeaders2.append("X-CSRF-TOKEN", token);

                    var urlencoded2 = new URLSearchParams();

                    var requestOptions2 = {
                        method  : 'POST',
                        headers : myHeaders2,
                        body    : urlencoded2,
                        redirect: 'follow'
                    };

                    var response2        = await fetch("logout", requestOptions2);
                    window.location.href = 'login';
                } else {
                    this.$refs.message.modal.show();
                }
            }
        }
    },
    mounted() {
        this.verify();
    }
}
</script>

<style scoped>
.info {
    text-align    : center;
    color         : var(--standart-gray);
    margin-bottom : 14px;
}

.login-window {
    height : 670px;
}
</style>
