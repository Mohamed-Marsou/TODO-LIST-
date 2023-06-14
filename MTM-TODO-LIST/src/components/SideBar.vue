<script>
import axios from 'axios';
export default {
    data() {
        return {
            items: [
                { label: "Example List", color: "green", count: 0 },
            ],
            TaskDetailsCount: [],
            isVisible: false,
        };
    },
    mounted() {
        // Fetch the tag count data from the API
        this.fetchTagCounts();
        this.fetchTaskCounts();
    },
    methods: {
        handleClick() {
            this.isVisible = !this.isVisible;
        },
        handleClick() {
            this.isVisible = !this.isVisible;
        },
        async fetchTagCounts() {
            axios.get("http://127.0.0.1:8000/api/tag/statistics")
                .then(response => {
                    const tagCounts = response.data;

                    if (tagCounts.length > 0) {
                        this.items = tagCounts.map(tag => ({
                            id: tag.id,
                            label: tag.name,
                            count: tag.count,
                            color: tag.color,
                        }));
                    }


                })
                .catch(error => {
                    console.error('Error fetching tag counts:', error);
                });
        }, async fetchTaskCounts() {
            axios.get("http://127.0.0.1:8000/api/task/details")
                .then(response => {
                    this.TaskDetailsCount = response.data;
                    this.fetchTagCounts();
                })
                .catch(error => {
                    console.error('Error fetching tag counts:', error);
                });
        },  navigateToAbout() {
      this.$router.push('/sticky');
    }
    },  
};
</script>

<template>
    <aside :class="{ hide: isVisible }">
        <div class="slot">
            <h2>Menu</h2>
            <form action="#" method="get">
                <span class="material-symbols-outlined">
                    search
                </span>
                <input type="search" name="search" placeholder="Search">
            </form>
            <span class="material-symbols-outlined" id="menuBtn" @click="handleClick">
                menu
            </span>
        </div>
        <div class="list_Container">

            <div class="slot fs">
                <small>Task</small>
                <ul>
                    <li class="active">
                        <a>
                            <span class="material-symbols-outlined">
                                double_arrow
                            </span>
                            Upcoming
                        </a>
                        <p>{{ TaskDetailsCount.total_tasks_count }}</p>
                    </li>
                    <li>
                        <a>
                            <span class="material-symbols-outlined">
                                today
                            </span>
                            Today
                        </a>
                        <p>{{ TaskDetailsCount.tasks_today }}</p>
                    </li>
                </ul>
            </div>

            <div class="slot fs">
                <small>List</small>
                <ul>
                    <li v-for="item in items" :key="item.id">
                        <a>
                            <div class="clr" :style="{ backgroundColor: item.color }"></div>
                            {{ item.label }}
                        </a>
                        <p>{{ item.count }}</p>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>

<style lang="scss" scoped>
@import '../assets/styles/shared.scss';

.material-symbols-outlined {
    font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48
}

aside {
    width: 25vw;
    height: 100vh;
    border-right: 1px solid rgba(0, 0, 0, 0.158);
    color: $mainFontColor;
    transition: .5s ease-in-out;

    .slot {
        width: 100%;
        min-height: 4rem;
        font-family: $mainff;
        position: relative;

        >h2 {
            padding: 0.5rem 0 0 1rem;
        }

        >form {
            width: 90%;
            height: 2.5rem;
            margin: 1rem auto;
            display: flex;
            align-items: center;
            border-radius: 5px;
            border: 2px solid rgba(0, 0, 0, 0.151);

            >input {
                width: 85%;
                height: 100%;
                border: none;
                outline: none;
            }

            >span {
                color: rgb(134, 134, 134);
                width: 15%;
                height: 100%;
                font-weight: bold;
                @include flexBox();
                cursor: pointer;
            }
        }

        #menuBtn {
            position: absolute;
            top: 1vh;
            right: 0.5vw;
            font-size: 2rem;
            cursor: pointer;
        }
    }

    .list_Container {
        z-index: 100%;
        height: 75%;
        overflow-y: scroll;

        &::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        & {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .fs {
            margin-top: 2rem;

            small {
                margin: 0 1rem;
                font-weight: bold;
            }

            ul {
                width: 100%;
                height: fit-content;
                padding: 1rem .5rem;

                li {
                    margin-top: .5rem;
                    font-size: .85rem;
                    width: 100%;
                    height: 3rem;
                    display: flex;
                    cursor: pointer;
                    transition: .3s ease-out;
                    position: relative;
                    margin-left: .5rem;

                    &:hover {
                        background-color: #55555523;
                        padding-left: 0.5rem;
                        font-weight: bold;
                    }

                    &:hover p {
                        background-color: #a1a1a1f6;
                    }

                    a {
                        @include flexBox($j-c: flex-start);
                        gap: .5rem;
                    }

                    .clr {
                        width: 22px;
                        height: 22px;
                        background-color: aquamarine;
                        border-radius: 5px;
                    }

                    p {
                        position: absolute;
                        right: 1rem;
                        top: 50%;
                        transform: translateY(-50%);
                        background-color: #a1a1a18e;
                        padding: 2px 5px;
                        color: aliceblue;
                        aspect-ratio: 1;
                        /* Maintain a 1:1 aspect ratio */
                        border-radius: 15%;
                        /* Apply border-radius to create a circle */
                        transition: 0.3s ease-in;

                    }
                }

            }
        }
    }

}

// TG Aside 
.hide {
    width: 5vw !important;

    ul,
    form,
    h2,
    small,
    .logOut {
        display: none !important;
    }

    #menuBtn {
        right: 50% !important;
        transform: translateX(50%);
        top: 2rem !important;
        font-size: 2.5rem !important;
    }
}

@media screen and (max-width:1200px) {
    aside {
        width: 30vw;
    }
}

.active {
    background-color: #55555523;
    padding-left: 0.5rem;
    font-weight: bold;
}
</style>