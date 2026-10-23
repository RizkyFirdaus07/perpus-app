<script setup>
import { ref } from 'vue';
import Sidebar from '@/Components/Sidebar.vue';
// ...import lain bawaan Breeze...
</script>
<template>
 <!-- Sidebar + Page Content -->
 <div class="flex">
 <Sidebar />
 <div class="flex-1">
 <!-- Page Heading -->
 <header
 class="bg-white shadow"
v-if="$slots.header"
>
 <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
 <slot name="header" />
 </div>
 </header>
 <!-- Page Content -->
 <main>
 <slot />
 </main>
 </div>
 </div>
</template>
