<template>

</template>

<script>
export default {
    data() {
        return {
            resp: null
        }
    },
    methods: {
        async start() {
            var requestOptions = {
                method  : 'GET',
                redirect: 'follow'
            };

            fetch("api/test/all", requestOptions)
                .then(response => response.text())
                .then(result => console.log(result))
                .catch(error => console.log('error', error));
        },
        async getPermissions() {
            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", "2");
            urlencoded.append("user_id", "5");

            var requestOptions = {
                method  : 'POST',
                headers : myHeaders,
                body    : urlencoded,
                redirect: 'follow'
            };

            var response = await fetch("api/user/getpermissions", requestOptions);
            if (response.ok) {
                this.resp = await response.json();
            }
        },
    },
    mounted() {
        this.start();
    }
}

</script>

<style scoped>

</style>
