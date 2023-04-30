<template>
    <div class="div_1">
        <table class="booking-table table-striped">
            <thead>
            <tr>
                <th style="width: 200px"></th>
                <th>08:00</th>
                <th>09:00</th>
                <th>10:00</th>
                <th>11:00</th>
                <th>12:00</th>
                <th>13:00</th>
                <th>14:00</th>
                <th>15:00</th>
                <th>16:00</th>
                <th>17:00</th>
                <th>18:00</th>
                <th>19:00</th>
                <th>20:00</th>
                <th>21:00</th>
                <th>22:00</th>
                <th>23:00</th>
                <th>00:00</th>
                <th>01:00</th>
                <th>02:00</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="t in maps">
                <td>{{ t.map_comp_id }}</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
                <td>&emsp;</td>
            </tr>
            </tbody>
        </table>
    </div>

    <table class="tdata">
        <tr v-for="m in maps">
            <td><div class="off" :style="{width: m.offset *1.3833 + 'px' }"></div><div class="bar" :style="{width: m.diff *1.3833 + 'px' }"></div></td>
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

            var resonse = await fetch("api/booking/draw", requestOptions);
            this.maps = await resonse.json();
            var cnt = this.maps.length;
            console.log(cnt);
            var i = 0;
            for (i = 0; i <= 19 - cnt; i++) {
                this.maps.push('');
            }
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
    left: 321px;
}
.tdata .bar {
    background-color: var(--dark-green);
    height: 30px;
    border-radius: 5px 30px 5px 30px;
    display: inline-block;
    margin-top: 12px;
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
