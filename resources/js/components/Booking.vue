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
            <tr v-for="t in 50">
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
                <td>&emsp;</td>
            </tr>

            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "Booking",
    data() {
        return {
            tdata: []
        }
    }
}
</script>

<style scoped>
.div_1::-webkit-scrollbar {
    width: 12px;               /* ширина scrollbar */
}
.div_1::-webkit-scrollbar-track {
    background: var(--dark-green);        /* цвет дорожки */
}
.div_1::-webkit-scrollbar-thumb {
    background-color: var(--light-green);    /* цвет плашки */
    border-radius: 20px;       /* закругления плашки */
    border: 3px solid var(--standart-black);  /* padding вокруг плашки */
}
.div_1 {
    width: 1780px;
    height: 880px;
    color: white;
    border-radius: 20px;
    overflow: auto;
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
}

</style>
