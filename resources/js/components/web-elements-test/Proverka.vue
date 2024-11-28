<template>
    <div>
        <button class="btn btn-success" @click="show">Show</button>
        <button class="btn btn-danger" @click="hide">Hide</button>
        <div v-if="showBox" :class="{ 'show': fade }" class="fade-in"></div>
    </div>
</template>

<script>
export default {
    name: "Test",
    data() {
        return {
            showBox: false,
            fade   : false,
        };
    },
    methods: {
        show() {
            this.showBox = true;
            this.$nextTick(() => {
                setTimeout(function () {
                    this.fade = true;
                }.bind(this), 100)
            });
        },
        hide() {
            this.fade = false;
            this.$nextTick(() => {
                setTimeout(function () {
                    this.showBox = false;
                }.bind(this), 1000)
            });
        }
    }
}
</script>

<style scoped>
.fade-in {
    opacity    : 0;
    transition : opacity 0.5s ease-in-out;
    width      : 100px;
    height     : 100px;
    background : #0a58ca;
    position   : relative;
    left       : 10px;
    top        : 10px;
}

.show {
    opacity : 1;
}
</style>
