import { useState } from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import NavLink from '@/Components/NavLink';
import Dropdown from '@/Components/Dropdown';

export default function Authenticated({ user, header, children }) {

    return (
        <>
        <div className="sidebar sidebar-dark sidebar-fixed" id="sidebar">
      <div className="sidebar-brand d-none d-md-flex">
      <Link href="/admin">
        <ApplicationLogo className="block h-9 w-auto fill-current text-white-800" />
      </Link>
      </div>
      <ul className="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li className="nav-item">
            <NavLink className="nav-link" href={route('dashboard')} active={route().current('dashboard')}>
                <div className="nav-icon">
                    <i className='fa fa-dashboard'></i>
                </div> Dashboard
            </NavLink>
        </li>
        <li className="nav-item">
            <NavLink className="nav-link" href={route('admin.category.index')} active={route().current('admin.category.index')}>
                <div className="nav-icon">
                    <i className='fa fa-list-alt'></i>
                </div> Category
            </NavLink>
        </li>
        <li className="nav-item">
            <NavLink className="nav-link" href={route('admin.product.index')} active={route().current('admin.product.index')}>
                <div className="nav-icon">
                    <i className='fa fa fa-product-hunt'></i>
                </div> Product
            </NavLink>
        </li>
        <li className="nav-item">
            <NavLink className="nav-link" href={route('dashboard')}>
                <div className="nav-icon">
                    <i className='fa fa-user'></i>
                </div> User
            </NavLink>
        </li>
        
      </ul>
    </div>
    <div className="wrapper d-flex flex-column min-vh-100 bg-light">
    <header className="header header-sticky mb-4">
        <div className="container-fluid">
          <button className="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg className="icon icon-lg">
              <use href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
            </svg>
          </button><a className="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
              <use href="assets/brand/coreui.svg#full"></use>
            </svg></a>
          
          <ul className="header-nav ms-auto">
            <li className="nav-item"><a className="nav-link" href="#">
                <svg className="icon icon-lg">
                  <use href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                </svg></a></li>
            <li className="nav-item"><a className="nav-link" href="#">
                <svg className="icon icon-lg">
                  <use href="vendors/@coreui/icons/svg/free.svg#cil-list-rich"></use>
                </svg></a></li>
            <li className="nav-item"><a className="nav-link" href="#">
                <svg className="icon icon-lg">
                  <use href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                </svg></a></li>
          </ul>
          <ul className="header-nav ms-3">
          <Dropdown>
                                    <Dropdown.Trigger>
                                        <span className="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {user.name}

                                                <svg
                                                    className="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fillRule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clipRule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </Dropdown.Trigger>

                                    <Dropdown.Content>
                                        <Dropdown.Link href={route('profile.edit')}>Profile</Dropdown.Link>
                                        <Dropdown.Link href={route('logout')} method="post" as="button">
                                            Log Out
                                        </Dropdown.Link>
                                    </Dropdown.Content>
                                </Dropdown>
          </ul>
        </div>
        <div className="header-divider"></div>
        <div className="container-fluid">
          <nav aria-label="breadcrumb">
            <ol className="breadcrumb my-0 ms-2">
              <li className="breadcrumb-item">
                <span>Home</span>
              </li>
              <li className="breadcrumb-item active"><span>Dashboard</span></li>
            </ol>
          </nav>
        </div>
      </header>

    <main>{children}</main>
    
    <footer className="footer">
        <div><a href="https://coreui.io">Demo Ecomm App </a> © 2023 Avyatech.</div>
        <div className="ms-auto">Powered by&nbsp;<a href="https://avyatech.com">Avyatech</a></div>
      </footer>
      </div>
    </>
    );
}
