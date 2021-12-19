<template>
    <div>
        <Crud :key="key" @changeKey="changekey($event)" />
    </div>
</template>
<script>
import Crud from "./components/Crud.vue";
export default {
    data() {
        return {
            key: 0,
        };
    },
    methods: {
        changekey(event) {
            this.key = event;
        },
    },
    components: {
        Crud,
    },
};
</script>
