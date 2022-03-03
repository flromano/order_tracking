<template>
    <div>
        <div class="lg:grid lg:grid-cols-5 lg:min-h-screen">
            <div class="bg-gray-300 lg:col-span-1 xl:col-span-1 lg:container py-8">
                <application-logo class="mx-auto h-10" />
            </div>
            <div class="lg:col-span-3 xl:col-span-4 p-6">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
import ApplicationLogo from '../Jetstream/ApplicationLogo'
export default {
    name: "AdooreiLayout.vue",
    components: { ApplicationLogo }
}
</script>

<style scoped>

</style>
