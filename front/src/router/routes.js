const routes = [
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      {
        path: "",
        name: "home",
        component: () => import("pages/products/Index.vue"),
      },
      {
        path: "/cart",
        name: "cart",
        meta: {
          isAuthenticated: true
        },
        component: () => import("pages/cart/Index.vue"),
      },
      {
        path: "/my-requests",
        name: "requests",
        component: () => import("pages/my_requests/Index.vue"),
      },
    ],
  },
  {
    path: "/login",
    component: () => import("layouts/LoginLayout.vue"),
    children: [
      {
        path: "",
        name: "login",
        component: () => import("pages/login/Index.vue"),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
