<template>
    <div class="alert alert-danger">
        <div v-for="(error, index) in err" :key="index">{{ error[0] }}</div>
    </div>
</template>

<script>
export default {
    props: ["err"],
};
</script>
