<script setup>
import Container from './components/Container.vue'
import SideBar from './components/SideBar.vue'
</script>

<template>
  <div class="_mainContainer">
    <SideBar />
    <Container />
  </div>
</template>

<style lang="scss" >
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
._mainContainer {
  width: 100vw;
  height: 100vh;
  display: flex;
  overflow: hidden;
}
</style>
