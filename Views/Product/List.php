<style>
  .page-header {
      text-align: left;
  }
</style>

<div id="app" v-cloak>

  <div class="d-flex flex-row justify-content-between col-md-12">

    <h1 class="page-header"> <?php echo $title; ?> </h1>

    <div class="page-btn-container">

      <a href="/add-product/" class="btn btn-info m-3"> ADD </a>

      <a v-if="deletables.length" href="" @click.prevent="deleteProducts" class="btn btn-danger m-3" id="delete-product-btn"> MASS DELETE </a>
      <a v-else href="" class="btn btn-danger m-3 disabled" id="delete-product-btn"> MASS DELETE </a>

    </div>

  </div>

  <hr class="m-1">

  <div class="d-flex flex-wrap col-md-12">
  
    <product-card 
      v-for="product in products"
      :key="product.id"
      :product="product"
      :toggle="toggleDelete" 
    />
  
  </div>

</div>

<script src="https://unpkg.com/vue@3"></script>
<script>
  
  let app = Vue.createApp({
      data() {
          return {
            products: <?php echo json_encode($products); ?>,
            deletables: [],
          }
      },
      methods: {
        toggleDelete(id) {
          getValue = item => item
        
          const index = this.deletables.findIndex(i => getValue(i) === getValue(id));
          
          if (index === -1) 
            this.deletables.push(id);
          else
            this.deletables.splice(index, 1);
        },
        deleteProducts() {
          this.deletables.forEach((id) => {

            fetch(window.location.origin + window.location.pathname + "api/delete-product/", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({ 
                product_type: this.products[id].type,
                id: id 
              })
            })
              .then(response => response.json())
              .then(data => (this.state = data.msg));
              
            delete this.products[id]
          })
          
          this.deletables = []
        },
      }
  })
  
  app.component("product-card", {
    props: ["product", "toggle"],
    template: `
      <div class="product-card col-md-3 mt-4 mb-4">
        <div class="card pb-5">
          <div class="card-body d-flex flex-column">

            <div class="d-flex justify-content-start mb-2">
              <input @click="toggle(product.id)" class="delete-checkbox" type="checkbox" value="">
            </div>

            <div> {{ product.sku }} </div>
            <div> {{ product.name }} </div>
            <div> {{ product.price }} $ </div>
            <div> {{ product.details }} </div>

          </div>
        </div>
      </div>
    `
  })

  app.mount('#app')
</script> 

