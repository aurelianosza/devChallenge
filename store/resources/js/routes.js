import HelloWorld from './components/HelloWorld';
import ExampleComponent from './components/ExampleComponent';
import Home from './components/Home';
import Login from './components/Auth/LoginComponent';
import Dashboard from './components/Dashboard/DashboardComponent';
import Products from './components/Dashboard/Pages/ProductsComponent';
import Product from './components/Dashboard/Pages/ProductComponent';
import IndexDashboard from './components/Dashboard/Pages/Index';
import LoadProducts from './components/Dashboard/Pages/LoadProducts';



export const routes = [{
        path: '/hello',
        name: 'hello',
        component: HelloWorld
    },
    {
        path: '/example',
        component: ExampleComponent,
        name: 'example'
    },
    {
        path: '/',
        component: Home,
        name: 'home'
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
            guest: true
        }
    },
    {
        path: '/dashboard',
        component: Dashboard,
        meta: {
            protected: true
        },
        children: [{
                path: '',
                name: 'dashboard',
                component: IndexDashboard
            },
            {
                path: 'products',
                name: 'products',
                component: Products
            },
            {
                path: 'products/add',
                name: 'add-products',
                component: Product
            },
            {
                path: 'products/load',
                name: 'load-products',
                component: LoadProducts
            },
            {
                path: 'products/:id',
                name: 'edit-products',
                component: Product
            },
        ]
    },
    {
        path: "*",
        redirect: '/404'
    }
];
