<?php


class ControllerApiNewWorkPlace extends Controller
{
    public function getTest()
    {
        $this->load->model('workplace/test');

        try {
            $data = $this->model_workplace_test->getTest();

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }


    public function getCategory()
    {
        $this->load->model('workplace/product');

        try {
            $data = $this->model_workplace_product->getCategory();

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }


    public function getProductCart()
    {
        $this->load->model('workplace/product');
        try {
            $data = $this->model_workplace_product->getProductCart();

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }


    public function updateViewed()
    {
        $product_id = (int)$this->request->get['productId'];
        $this->load->model('workplace/product');
        try {
            $data = $this->model_workplace_product->updateViewed($product_id);

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }


    public function carouselProducts()
    {
        $this->load->model('workplace/product');
        try {
            $data = $this->model_workplace_product->carouselProducts();

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }


    public function getProductOptions()
    {
        $product_id = (int)$this->request->get['productId'];
        $language_id = (int)$this->request->get['language_id'];
        $this->load->model('workplace/product');
        try {
            $data = $this->model_workplace_product->getProductOptions($product_id, $language_id);

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }


    public function getProductRelated()
    {
        $product_id = (int)$this->request->get['productId'];
        $language_id = (int)$this->request->get['language_id'];
        $this->load->model('workplace/product');
        try {
            $data = $this->model_workplace_product->getProductRelated($product_id, $language_id);

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }


    public function getDeliveryByCity()
    {
        $this->load->model('workplace/product');
        try {
            $data = $this->model_workplace_product->getDeliveryByCity();

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }


    public function getCategoryName()
    {
        $this->load->model('workplace/product');
        try {
            $data = $this->model_workplace_product->getCategoryName();

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }

    public function getCategoryProducts()
    {
        $this->load->model('workplace/product');
        try {
            $data = $this->model_workplace_product->getProductsByCategory();

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }


    public function carouselProductsViewed(){
        $this->load->model('workplace/product');
        try {
            $data = $this->model_workplace_product->carouselProductsViewed();

            if ($data['success']) {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data));

            } else {
                $this->response->addHeader('Content-Type: application/json');
                $this->response->addHeader($data['status']);
                $this->response->setOutput(json_encode($data['error']));
            }
        } catch (Exception $e) {
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput($e->getMessage(), 500);
        }
    }
}