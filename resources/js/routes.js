
// Auth Components
import Login from './Pages/Login.vue';
import Register from './Pages/Register.vue';
import Dashboard from './Pages/Dashboard.vue';
// Importing Expenses Categories Components
import ExpenseCategoriesList from './components/ExpensesCategories/ExpenseCategoriesList.vue';
// Importing Expenses Components
import ExpensesList from './components/Expenses/ExpensesList.vue';
// Importing Setting Compoent
import Settings from './Pages/Settings.vue';

// Importing Notes Components
import NotesVue from './components/Notes/Notes.vue';


//Messages
import Messages from './components/Messages/Messages.vue';
import ProductMessages from './components/ProductMessages/Messages.vue';
import SingleMessage from './components/Messages/SingleMessage.vue';
import SingleProductMessage from './components/ProductMessages/SingleMessage.vue';


//Blogs
import Blogs from './components/Blogs/Blogs.vue';
import CreateBlog from './components/Blogs/CreateBlog.vue';
import SingleBlog from './components/Blogs/SingleBlog.vue';

//Blog-Category
import BlogCategory from './components/BlogCategories/CategoriesList.vue';
import AddCategory from './components/BlogCategories/AddCategory.vue'
import UpdateCategory from './components/BlogCategories/UpdateCategory.vue'
//Brands 
import BrandsList from './components/Brands/BrandsList.vue';
import AddBrand from './components/Brands/AddBrand.vue';
import UpdateBrand from './components/Brands/UpdateBrand.vue';

//Types 
import TypesList from './components/Types/TypesList.vue';
import AddType from './components/Types/AddType.vue';
import UpdateType from './components/Types/UpdateType.vue';


// //Products Route 
import Products from './components/Products/Products.vue';
import CreateProduct from './components/Products/CreateProduct.vue';
import SingleProduct from './components/Products/SingleProduct.vue';

//whatsapp
import Whatsapp from './components/Whatsapp/Whatsapp.vue';


export const routes = [
    {
        name: 'login',
        path: '/',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    // Routes for Expense Categories
    {
        name: 'expense-categories-list',
        path: '/expenses/categories',
        component: ExpenseCategoriesList,
    },
    // Routes for Expenses
    {
        name: 'expense-list',
        path: '/expenses/all',
        component: ExpensesList,
    },
    // Route for Settings
    {
        name: 'settings',
        path: '/settings',
        component: Settings
    },

    // Route for Notes 
    
    {
        name: 'notes',
        path: '/notes',
        component: NotesVue,
    },
    
    // Routes for Products Brands
    {
        name: 'products-brands-list',
        path: '/products-brands-list',
        component: BrandsList,
    },
    {
        name: 'products-brands-create',
        path: '/products-brands-list/create',
        component: AddBrand,
    },
    {
        name: 'products-brands-edit',
        path: '/products-brands-list/edit/:id',
        component: UpdateBrand,
    },


    // Routes for Products Types
    {
        name: 'products-types-list',
        path: '/products-types-list',
        component: TypesList,
    },
    {
        name: 'products-types-create',
        path: '/products-types-list/create',
        component: AddType,
    },
    {
        name: 'products-types-edit',
        path: '/products-types-list/edit/:id',
        component: UpdateType,
    },

     // Routes for Products
     {
        name: 'products',
        path: '/products',
        component:Products
    },
    {
        name: 'add-new-product',
        path: '/products/add-new-product',
        component:CreateProduct
    },
    {
        name: 'single-product',
        path: '/products/single-product/:id/:name',
        component:SingleProduct
    },
    {
        name: 'update-product',
        path: '/products/update/:id/:name',
        component:CreateProduct
    },

    

    //Blogs
    {
        name: 'blogs',
        path: '/blogs',
        component:Blogs
    },
    {
        name: 'add-new-blog',
        path: '/blogs/add-new-blog',
        component:CreateBlog
    },
    {
        name: 'single-blog',
        path: '/blogs/single-blog/:id/:name',
        component:SingleBlog
    },
    {
        name: 'update-blog',
        path: '/blogs/update/:id/:name',
        component:CreateBlog
    },
    
    //Blogs Category
    {
        name: 'blog-categories',
        path:'/blog-categories',
        component: BlogCategory,
    },
    {
        name: 'create-blog-category',
        path: '/blog-categories/create',
        component: AddCategory,
    },
    {
        name: 'categories-edit',
        path: '/blog-categories/edit/:id',
        component: UpdateCategory,
    },

        //Messaqqges
        {
            name: 'messages',
            path: '/messages',
            component:Messages
        },
        {
            name: 'product-messages',
            path:'/product/messages',
            component: ProductMessages,
        },
        {
            name: 'single-message',
            path: '/messages/single-message/:id/:name',
            component:SingleMessage
        },
        {
            name: 'single-product-message',
            path: '/messages/single-product-message/:id/:name',
            component:SingleProductMessage
        },

        {
            name:'whatsapp',
            path:'/whatsapp-messages',
            component: Whatsapp,
        },
];