<script>
import axios from 'axios';

export default {
    data() {
        return {
            tasks: [],
            errorMessage: null,
            isLoading: true,
            isShow: true,

            NewTask: {
                name: "",
                description: "",
                color: "",
                tag: "",
                deadline: "",
                user_id: 1,
            }
        };
    },
    methods: {
        handleExpand(task) {
            task.isExpanded = !task.isExpanded;
        },
        handleTaskForm() {
            this.isShow = !this.isShow;
        },
        handleTaskHidding() {
            this.isShow = !this.isShow;
        },

        async removedTask(index) {
            const task = this.tasks[index];
            task.isRemoved = !task.isRemoved; // Toggle the isRemoved property

            if (task.isRemoved) {
                try {
                    const response = await axios.post(`http://127.0.0.1:8000/api/tasks/${task.id}/delete`);
                    // Handle the successful response
                    console.log('Task deleted:', response.data);
                } catch (error) {
                    // Handle the error response
                    console.error('An error occurred:', error);
                }
            } else {
                try {
                    const response = await axios.post(`http://127.0.0.1:8000/api/tasks/${task.id}/undo`);
                    // Handle the successful response
                    console.log('Task updated:', response.data);
                } catch (error) {
                    // Handle the error response
                    console.error('An error occurred:', error);
                }
            }
        },
        async fetchData() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/mytasks');
                this.tasks = response.data;
                this.isLoading = false;
            } catch (error) {
                this.errorMessage =
                    'An error occurred while fetching the data. Please try again later.';
            }
        },
        submitForm() {
            axios.post('http://127.0.0.1:8000/api/newtask', this.NewTask)
                .then(response => {
                    // Handle the successful response
                    console.log('Task created:', response.data);
                    // Reset the form after successful submission
                    this.NewTask.name = '';
                    this.NewTask.description = '';
                    this.NewTask.tag = "";
                    this.NewTask.color = "";
                    this.NewTask.deadline = "";
                    this.isShow = true;
                    this.fetchData()
                })
                .catch(error => {
                    // Handle the error response
                    console.error('An error occurred:', error);
                });
        },
    },
    mounted() {
        this.fetchData();
    },
};
</script>
<template>
    <main>
        <header>
            <h1>
                MTM TODO-LIST
            </h1>
        </header>

        <div class="mainBox">
            <div class="addTaskWrapper" @click="handleTaskForm">
                <span class="material-symbols-outlined">
                    add
                </span>
                <p>Add new Task</p>
            </div>

            <div class="Tasks_container">
                <div v-if="errorMessage" class="error-message">
                    <p style="color: red; font-size: 1.5rem; text-align: center;">
                        {{ errorMessage }}
                    </p>
                </div>

                <div v-if="isLoading" class="loading-message">
                    <div class="task lazzyLoading">
                        <div class="mright"></div>
                    </div>
                    <div class="task lazzyLoading">
                        <div class="mright"></div>
                    </div>
                </div>

                <div v-else>
                    <div class="task " v-for="(task, index) in tasks" :key="task.id"
                        :class="{ task_removed: task.isRemoved }">
                        <div class="head">
                            <input type="checkbox" v-model="task.isRemoved" @click="removedTask(index)">
                            <p class="task-name" @click="handleExpand(task)">{{ task.name }}</p>
                            <span class="material-symbols-outlined" @click="handleExpand(task)">
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
                                <p>{{ task.deadline }}</p>
                            </div>
                            <div class="dw spdw">
                                <div :style="`background-color: ${task.tag.color}`" class="tag-bg"></div>
                                <p>{{ task.tag ? task.tag.name : '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay " :class="{ taskFromVisibility: isShow }" @click="handleTaskHidding"></div>
        <div class="addTaskContainer " :class="{ taskFromVisibility: isShow }">
            <p>Create new Task</p>
            <form action="http://127.0.0.1:8000/api/newtask" method="POST" @submit.prevent="submitForm">
                <div class="inpt">
                    <label for="name">Task Name</label>
                    <input type="text" name="name" placeholder="name" v-model="NewTask.name">
                </div>
                <div class="inpt">
                    <label for="name">Task date</label>
                    <input type="date" name="date" title="Deadline" v-model="NewTask.deadline">
                </div>
                <div class="inpt">
                    <label for="name">Task Label</label>
                    <input type="text" name="tag" placeholder="Ex: work" v-model="NewTask.tag" title="Label">
                </div>
                <div class="inpt">
                    <label for="name">Label color</label>
                    <input type="color" name="color" title="color" v-model="NewTask.color">
                </div>
                <div class="inpt">
                    <label for="clr-date">Task Details</label>
                    <textarea name="description" id="description " v-model="NewTask.description">
                                                </textarea>
                </div>
                <button type="submit">Submit</button>
            </form>
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
    position: relative;

    header {
        padding: 1rem;
        height: 10vh;
        width: 100%;

        >h1 {
            span {
                padding: 1rem;
                color: #555;
                cursor: pointer;
            }
        }
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
                }
            }
        }
    }

    .hidden {
        display: none !important;
        transition: 1s ease-in;
    }
}

@media screen and (max-width:1200px) {
    main {
        width: 70vw;
    }
}

.lazzyLoading {
    height: 5rem;
    background-color: #dfdddd;
    border: azure 1px solid !important;
    align-items: flex-start !important;
    filter: blur(5px);
    animation: blury 1s ease-in;
}

@keyframes blury {
    0% {
        filter: blur(2px);
        background-color: #ececec;
    }

    100% {
        filter: blur(2px);
        background-color: #dfdddd;

    }

}


// addTaskContainer
.overlay {
    width: 100vw;
    height: 100vh;
    position: absolute;
    background: #3a3a3a3f;
    top: 0;
    left: 0;
}

.addTaskContainer {
    width: 50vw;
    height: 90vh;
    position: absolute;
    background: #fff;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    padding: 1rem;
    font-family: $mainff;

    p {
        font-size: 3rem;
        text-align: center;
        padding: 1rem;
        font-weight: 700;
    }

    .inpt {
        width: 70%;
        min-height: 4rem;
        display: flex;
        flex-direction: column;
        gap: .5rem;
        margin: 0 auto;

        input[type='text'] {
            width: 70%;
            height: 3rem;
            font-size: 1rem;
            font-family: $mainff;
            padding: 0 1rem;
        }

        input[type='date'] {
            width: 10rem;
            height: 3rem;
        }

        textarea {
            width: 70%;
            height: 7rem;
        }
    }

    button {
        width: 8rem;
        height: 3rem;
        margin: 1rem 35%;
        float: right;
        border: none;
        border-radius: 20px;
        color: azure;
        text-transform: uppercase;
        cursor: pointer;
        transition: .3s ease-in-out;
        background-color: rgb(255, 34, 34);

        &:hover {
            background-color: rgb(253, 0, 0);
        }
    }
}

.taskFromVisibility {
    display: none !important;
}

.task_removed {
    text-decoration: line-through;
    transition: .9s ease-in-out;
    opacity: .5;
}
</style>