<template>
    <div class="div_1">
        <table class="booking-table table-striped">
            <thead>
            <tr>
                <th style="width: 200px"></th>
                <th v-for="t in 24">{{ t-1 }}:00</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="t in maps">
                <td>{{ t.id_comp }}</td>
                <td v-for="t in 24">&emsp;</td>
            </tr>
            </tbody>
        </table>
    </div>

    <table class="tdata">
        <tr v-for="m in maps">
            <td>
                <template v-for="f in m.fulldata">
                    <div class="off" :style="{width: f.offset *1.145 + 'px' }"></div><div class="bar" :style="{width: f.diff *1.145 + 'px' }"><span>{{ f.f3 }}</span></div>
                </template>
            </td>
        </tr>
    </table>
</template>

<script>
export default {
    name: "Booking",
    props: ['club_id'],
    data() {
        return {
            maps: []
        }
    },
    methods: {
        async draw() {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0');
            const day = today.getDate().toString().padStart(2, '0');
            const todayFormatted = `${year}-${month}-${day}`;

            var myHeaders = new Headers();
            myHeaders.append("Content-Type", "application/x-www-form-urlencoded");

            var urlencoded = new URLSearchParams();
            urlencoded.append("club_id", this.$props.club_id);
            urlencoded.append('time_start', todayFormatted);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: urlencoded,
                redirect: 'follow'
            };

            var resonse = await fetch("api/booking/draw", requestOptions);
            this.maps = await resonse.json();
            // this.maps = await resonse.json();
            // var cnt = this.maps.length;
            // console.log(cnt);
            // var i = 0;
            // for (i = 0; i <= 19 - cnt; i++) {
            //     this.maps.push('');
            // }
        }
    },
    mounted() {
        this.draw();
    }
}
</script>

<style scoped>
.off {
    height: 30px;
    color: yellow;
    display: inline-block;
}
.tdata {
    position: absolute;
    top: 116px;
    left: 257px;
}
.tdata .bar {
    background-color: var(--dark-green);
    height: 30px;
    border-radius: 5px 30px 5px 30px;
    display: inline-block;
    margin-top: 12px;
    text-align: center;
}
.tdata .bar span {
    display: inline-block;
    margin-top: 4px;
    color: var(--standart-gray);
}
.div_1 {
    width: 1794px;
    height: 900px;
    color: white;
    border-radius: 20px;
    overflow: hidden;
    margin-left: 11px;
}

.booking-table {
    border-radius: 30px;
    color: var(--standart-gray);
}
.booking-table th {
    text-align: center;
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    z-index: 2;
}
.booking-table th:not(:first-child) {
    width: 83px;
}
.booking-table td:nth-child(2n+1) {
    background-color: var(--standart-black)
}
.booking-table th:first-child {
    background: #284f62;
}
.booking-table td:first-child {
    background: #284f62;
    height: 44.2px;
    text-align: center;
}

</style>
