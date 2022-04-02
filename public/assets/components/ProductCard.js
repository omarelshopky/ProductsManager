export default {
  name: "productcard",
  props: ["product"],
  template: `
    <div class="product-card col-md-3 mt-4 mb-4">
      <div class="card pb-5">
        <div class="card-body d-flex flex-column">

          <div class="d-flex justify-content-start mb-2">
            <input class="delete-checkbox" :id="product.id" type="checkbox" value="">
          </div>

          <div> {{ product.sku }} </div>
          <div> {{ product.name }} </div>
          <div> {{ product.price }} $ </div>
          <div> {{ product.details }} </div>

        </div>
      </div>
    </div>
  `
};
