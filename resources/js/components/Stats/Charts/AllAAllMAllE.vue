<template>
    <pre>{{ stats }}</pre>
</template>

<script>
export default {
    props: {
        stats: {
            type: Object,
            required: true
        },
    }
}
</script>
