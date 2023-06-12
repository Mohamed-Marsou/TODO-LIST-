<script>
export default {
    data() {
        return {
            tasks: [
                {
                    id: 1,
                    task: 'Do something'
                    , description: `
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat repellendus soluta commodi
                            optio delectus earum perspiciatis debitis recusandae, exercitationem fugit! Veniam adipisci
                            saepe ab culpa impedit vel voluptate explicabo laborum nulla tempora sed, eos minus qui dicta
                            dolore quam ratione illo velit optio. Exercitationem, tempore. Asperiores nulla, laboriosam
                            saepe optio fugiat quidem totam inventore at.
                    `,
                    completed: false,
                    doDay: "25-10-2023",
                    tag: " GYM"
                },
                {
                    id: 2
                    ,
                    task: 'Do something'
                    , description: `
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat repellendus soluta commodi
                            optio delectus earum perspiciatis debitis recusandae, exercitationem fugit! Veniam adipisci
                            saepe ab culpa impedit vel voluptate explicabo laborum nulla tempora sed, eos minus qui dicta
                            dolore quam ratione illo velit optio. Exercitationem, tempore. Asperiores nulla, laboriosam
                            saepe optio fugiat quidem totam inventore at.
                    `,
                    completed: false,
                    doDay: "25-10-2023",
                    tag: " Personal"
                    , isExpanded: false
                }, {
                    id: 3
                    ,
                    task: 'Do something'
                    , description: `
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat repellendus soluta commodi
                            optio delectus earum perspiciatis debitis recusandae, exercitationem fugit! Veniam adipisci
                            saepe ab culpa impedit vel voluptate explicabo laborum nulla tempora sed, eos minus qui dicta
                            dolore quam ratione illo velit optio. Exercitationem, tempore. Asperiores nulla, laboriosam
                            saepe optio fugiat quidem totam inventore at.
                    `,
                    completed: false,
                    doDay: "25-10-2023",
                    tag: " Personal"
                    , isExpanded: false
                }
                , {
                    id: 4
                    ,
                    task: 'Do something'
                    , description: `
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat repellendus soluta commodi
                            optio delectus earum perspiciatis debitis recusandae, exercitationem fugit! Veniam adipisci
                            saepe ab culpa impedit vel voluptate explicabo laborum nulla tempora sed, eos minus qui dicta
                            dolore quam ratione illo velit optio. Exercitationem, tempore. Asperiores nulla, laboriosam
                            saepe optio fugiat quidem totam inventore at.
                    `,
                    completed: false,
                    doDay: "25-10-2023",
                    tag: " Personal"
                    , isExpanded: false
                }
            ],
            isHideen: true,
        };
    },
    methods: {
        handleExpand(event , task) {
            task.isExpanded = !task.isExpanded;
        }
    },
}
</script>

<template>
    <main>
        <header>
            <h1>
                MTM TODO-LIST
            </h1>
        </header>

        <div class="mainBox">
            <div class="addTaskWrapper">
                <span class="material-symbols-outlined">
                    add
                </span>
                <p>Add new Task</p>
            </div>

            <div class="Tasks_container">
                <div class="task" v-for="task in tasks" :key="task.id">
                    <div class="head">
                        <input type="checkbox">
                        <p class="task-name" @click="handleExpand($event,task)">{{ task.task }}</p>
                        <span class="material-symbols-outlined" @click="handleExpand($event, task)">
                            expand_more
                        </span>
                    </div>

                    <div class="disc" :class="{ hidden: !task.isExpanded }">
                        <h3>Description</h3>
                        <p>{{ task.description }}</p>
                    </div>

                    <div class="info" :class="{ hidden: !task.isExpanded }">
                        <div class="dw">
                            <span class="material-symbols-outlined">
                                calendar_month
                            </span>
                            <p>{{ task.doDay }}</p>
                        </div>
                        <div class="dw spdw">
                            <div class="tag-bg"></div>
                            <p>{{ task.tag }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<style lang="scss" scoped>
@import '../assets/styles/shared.scss';

main {
    width: 95vw;
    height: 100vh;
    font-family: $mainff;
    @include flexBox();
    flex-direction: column;
    gap: 1rem;

    header {
        padding: 1rem;
        height: 10vh;
        width: 100%;
    }

    .mainBox {
        width: 100%;
        height: 85vh;
        transition: .9s ease-in;
        overflow-y: scroll;

    }

    .addTaskWrapper {
        width: 90%;
        height: 3rem;
        border: 2px solid rgba(161, 163, 163, 0.514);
        margin: 1rem auto;
        border-radius: 5px;
        color: $mainFontColor;
        @include flexBox($j-c: flex-start);
        gap: .5rem;
        padding: 0 1rem;
        cursor: pointer;
    }


    .Tasks_container {
        width: 90%;
        min-height: 40vh;
        margin: 1rem auto;
        border-radius: 5px;
        color: $mainFontColor;
        gap: .5rem;
        cursor: pointer;

        .task {
            width: 100%;
            min-height: 3rem;
            margin: 1rem auto;
            border-radius: 5px;
            color: $mainFontColor;
            @include flexBox($j-c: flex-start);
            gap: .5rem;
            padding: 0 1rem;
            cursor: pointer;
            position: relative;
            flex-direction: column;
            transition: .3s ease-in;
            border: 2px solid rgba(161, 163, 163, 0.514);

        }

        .head {
            width: 100%;
            display: inline;
            height: 4rem;
            @include flexBox($j-c: flex-start);
            gap: .5rem;
            position: relative;
            padding: 0 .5rem;

            >span {
                position: absolute;
                right: 1rem;
                font-size: 1.7rem;
                top: 50%;
                transform: translateY(-50%);
                transition: .2s ease-in;
                border-radius: 50%;

                &:hover {
                    background: #b9b9b9;
                    color: azure;
                }
            }
        }

        .disc {
            width: 100%;
            min-height: 4rem;
            @include flexBox($a-i: flex-start);
            padding: 0 .5rem;
            flex-direction: column;
            gap: 1rem;
            transition: .3s ease-in;

            p {
                font-size: .9rem;
            }
        }

        .info {
            width: 100%;
            min-height: 3rem;
            @include flexBox($j-c: flex-start);
            padding: 0 .5rem;
            gap: 1rem;
            transition: .3s ease-in;

            .dw {
                min-width: 5rem;
                height: 2rem;
                background-color: rgb(221, 221, 221);
                border-radius: 5px;
                @include flexBox();
                color: #555;
                padding: 0 .5rem;
                font-size: .9rem;
                gap: .5rem;

                span {
                    font-size: 1.1rem;
                }
            }

            .spdw {
                background-color: transparent;

                .tag-bg {
                    width: 20px;
                    height: 20px;
                    border-radius: 5px;
                    background-color: green;
                }
            }
        }
    }

    .hidden {
        display: none !important;
        transition: 1s ease-in;
    }
}

@media screen and (max-width:1200px){
    main {
        width: 70vw;
    }
}
</style>