<template>
    <div v-if="contextMenuShow" class="overlay" @click="hideDiv"></div>
    <div v-show="contextMenuShow" id="context" :style="{left: contextMenuLeft + 'px', top: contextMenuTop + 'px', width: width + 'px'}" class="context-menu">
        <div v-for="(c, i) in contextMenuData" @click="selectedItem(i)">{{ c }}</div>
    </div>
</template>

<script>
export default {
    name: "context-menu",
    data() {
        return {
            contextMenuShow: false,
            contextMenuLeft: 100,
            contextMenuTop : 100,
            contextMenuData: [],
            width          : 200,
        }
    },
    methods: {
        selectedItem(i) {
            var item             = this.contextMenuData[i];
            this.contextMenuShow = false;
            this.$emit('onItemSelected', item);
        },
        hideDiv(event) {
            if (!event.target.closest('#context')) {
                this.hide();
            }
        },
        show() {
            this.contextMenuShow = true;
        },
        hide() {
            this.contextMenuShow = false;
        },
    },
    mounted() {
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                this.hide();
            }
        }.bind(this));
    }
}
</script>

<style lang="scss" scoped>
.context-menu {
    background    : var(--context-menu);
    box-shadow    : 0 1px 10px 0 rgba(0, 0, 0, 0.15);
    color         : white;
    position      : absolute;
    border-radius : 10px;
    overflow      : hidden;

    div {
        height       : 35px;
        width        : 100%;
        cursor       : pointer;
        display      : flex;
        align-items  : center;
        padding-left : 10px;

        &:hover {
            background : var(--light-blue-bg-color);
            color      : var(--standart-gray);
        }
    }
}

.overlay {
    position : fixed;
    top      : 0;
    left     : 0;
    width    : 100%;
    height   : 100%;
    //background-color: rgba(0, 0, 0, 0.5);
}
</style>
