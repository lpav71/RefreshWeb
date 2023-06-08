<template>
<div class="home">
    <div class="header">
        <div class="left">
            <div class="top"><img src="img/5.svg" alt=""/><span style="margin-left: 14px;">Сотрудники и роли</span></div>
        </div>
    </div>
    <div class="bottom">
        <div class="side">
            <button @click="editModal" class="btn butt" type="button">Добавить роль</button>
            <template v-for="p in positions">
                <div class="div_4 span-1">
                    <span>{{ p.position_name }}</span>
                </div>
            </template>
        </div>
        <div class="side">
            <div class="users">
                <div class="one_user" v-for="u in users">
                    <div class="foto"><img :src="u.icon" width="50" height="50" alt=""></div>
                    <div class="fio">
                        <span>{{ u.surname }} {{ u.name_auth }}</span><br><span class="c_position">{{ u.position_name }}</span>
                    </div>
                    <div class="invitation">
                        <span>Приглашён</span><br><span class="c_position">Васей Пупкиным</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>
export default {
    props: ['club_id'],
    data() {
        return {
            users: null,
            positions: null
        }
    },
    methods: {
        async getUsers() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/position/getuser", requestOptions);
            this.users = await response.json();
        },
        async getPositions() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/position/get", requestOptions);
            this.positions = await response.json();
        }
    },
    mounted() {
        this.getUsers();
        this.getPositions();
    }
}
</script>

<style scoped>
.c_position {
    color: var(--dark-green-b);
}
.foto {
    border-radius: 10px;
    overflow: hidden;
}
.fio {
    width: 210px;
    padding: 0 5px 0 10px;
}
.invitation {
    width: 210px;
    padding: 0 5px 0 10px;
}
.one_user {
    display: flex;
    padding: 8px;
    border-bottom: #034046 1px solid;
}
.users {
    width: 487px;
    height: 506px;
    background: var(--standart-black);
    border-radius: 20px;
    position: relative;
    left: 500px;
    padding: 20px;
}
.side {
    display: inline-block;
}
.span-1 {
    margin-top: 14px;
    display: block;
    font-size: inherit;
}
.div_4 {
    height: 35px;
    background: #172D39;
    padding: 5px 15px 5px 15px;
    margin-top: 20px;
    color: var(--standart-gray);
    border: none;
    width: 190px;
    border-radius: 8px;
    font-size: inherit;
}
.home {
    width: 1793px;
    height: 947px;
    color: var(--standart-gray);
    margin-left: 11px;
}
.home .header {
    display: flex;
    justify-content: space-between;
}
.home .header .left {
    width: 1060px;
}
.home .header {
    width: 516px;
    display: flex;
    justify-content: start;
}
.bottom {
    width: 1793px;
    height: 855px;
    background: var(--light-blue-bg-color);
    margin-top: 10px;
    border-radius: 20px;
    padding: 20px;
    display: flex;
}
.butt {
    background: var(--disable);
    border: none;
    border-radius: 5px 30px;
    height: 42px;
    margin-left: 20px;
    min-width: 94px;
    padding-right: 20px;
    padding-left: 20px;
    display: inline-block;
}
.butt1 {
    background: var(--disable);
    border: none;
    height: 42px;
    margin-top: 20px;
    min-width: 94px;
    padding-right: 20px;
    padding-left: 20px;
    display: inline-block;
    border-radius: 5px;
}
.top {
    width: 235px;
    height: 42px;
    display: inline-block;
}
</style>
