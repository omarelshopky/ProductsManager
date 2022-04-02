<style>
  .page-header {
      text-align: left;
  }
</style>

<div id="app" v-cloak>

  <div class="d-flex flex-row justify-content-between col-md-12">

    <h1 class="page-header"> <?php echo $title; ?> </h1>

    <div class="page-btn-container">

      <button type="button" @click="addProduct" class="btn btn-info m-3"> ADD </button>

      <button type="button" v-if="true" @click.prevent="deleteProducts" class="btn btn-danger m-3" id="delete-product-btn"> MASS DELETE </button>

    </div>

  </div>

  <hr class="m-1">

  <div class="d-flex flex-wrap col-md-12">
  
    <productcard 
      v-for="(product, i) in products"
      :key="i"
      :product="product"
    ></productcard>
  
  </div>

</div>

<script src="https://unpkg.com/vue@3"></script>
<script type="module">
  import productcard from "/public/assets/components/ProductCard.js"
  
  let app = Vue.createApp({
    components: {productcard},
    data() {
        return {
          products: <?php echo json_encode($products); ?>
        }
    },
    methods: {
      deleteProducts() {
        // Get Products with delete checked
        let deletables = []
        document.querySelectorAll(".delete-checkbox").forEach((checkbox) => {
          if (checkbox.checked) {
            deletables.push(checkbox)
          }
        })

        deletables.forEach((product) => {
          
          fetch(window.location.origin + "/api/delete-product/", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ 
              product_type: this.products[product.id].type,
              id: product.id 
            })
          })
            .then(response => response.json())
            .then(data => (this.state = data.msg));
            
          delete this.products[product.id]
        })
      },
      addProduct() {
        window.location.href = window.location.origin + "/add-product/"
      }
    }
  })
  
  app.mount('#app')
</script> 

