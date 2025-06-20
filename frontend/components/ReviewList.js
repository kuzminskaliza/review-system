import { ref, onMounted } from 'vue';

export default {
  setup() {
    const apiBase = 'http://api.review-system.local/api/review';

    const reviews = ref([]);
    const currentPage = ref(1);
    const totalPages = ref(1);

    const loadReviews = async (page = 1) => {
      try {
        const resp = await window.axios.get(apiBase, {
          params: { status: 'approved', page }
        });
        reviews.value = resp.data.items || resp.data;
        if (resp.data.meta) {
          totalPages.value = resp.data.meta.pageCount || 1;
          currentPage.value = resp.data.meta.currentPage || 1;
        } else {
          totalPages.value = 1;
          currentPage.value = 1;
        }
      } catch (error) {
        console.error('Помилка завантаження відгуків', error);
      }
    };

    const prevPage = () => {
      if (currentPage.value > 1) loadReviews(currentPage.value - 1);
    };

    const nextPage = () => {
      if (currentPage.value < totalPages.value) loadReviews(currentPage.value + 1);
    };

    onMounted(() => loadReviews());

    return {
      reviews,
      currentPage,
      totalPages,
      loadReviews,
      prevPage,
      nextPage,
    };
  },

  template: `
    <div v-if="reviews.length === 0">Відгуків поки немає</div>

    <table v-else class="review-table">
        <thead>
            <tr>
                <th>Автор</th>
                <th>Текст</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="review in reviews" :key="review.id">
            <td>{{ review.author_name }}</td>
            <td>{{ review.text }}</td>
            <td>{{ new Date(review.created_at).toLocaleString() }}</td>
            </tr>
        </tbody>
    </table>

    <div class="pagination" v-if="totalPages > 1">
        <button @click="prevPage" :disabled="currentPage === 1">← Попередня</button>
        <span>Сторінка {{ currentPage }} з {{ totalPages }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages">Наступна →</button>
    </div>
  `
};
