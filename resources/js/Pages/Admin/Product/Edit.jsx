import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, usePage } from '@inertiajs/react';
import React from 'react';
import Select from 'react-select';

export default function Edit({ auth, status_options, categories, colors, sizes, tags }) {

    const { product } = usePage().props;
    
    const { data, setData, post, errors, progress } = useForm({
        category_id: product.category_id || "",
        description: product.description || "",
        features: product.features || "",
        product_details: product.product_details || "",
        title: product.title || "",
        price: product.price || "",
        status: product.status,
        image: product.image || "",
        file: "",
        colors: product.colors,
        sizes: product.sizes,
        tags: product.tags
    });

    const handleColor = (selectedOptions) => {
        setData('colors', selectedOptions);
    };

    const handleSize = (selectedOptions) => {
        setData('sizes', selectedOptions);
    };

    const handleTag = (selectedOptions) => {
        setData('tags', selectedOptions);
    };

    const handleStatusChange = (e) => {
        const { value } = e.target;
        setData('status', value);
    };

    const handleCategoryChange = (e) => {
        const { value } = e.target;
        setData('category_id', value);
    };

    const handleFileChange = (event) => {
        const file = event.target.files[0];
        setData('file', file);
      };

    function handleSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('file', file);

        post(route("admin.product.update", product.id), formData, {
            headers: {
                'Content-Type': 'multipart/form-data', // Set the Content-Type header
            },
        });
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Edit Product</h2>}
        >
            <Head title="Edit Product" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            
                            <form onSubmit={handleSubmit} className="bg-white px-8 pt-6 pb-8 mb-4">
                            <div className="grid grid-cols-2 gap-4">
                            <div className="mb-4">
                                <label className="block text-gray-700 text-sm font-bold mb-2">
                                    Category
                                </label>
                                <select
                                onChange={handleCategoryChange}
                                value={data.category_id}
                                className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                
                                
                                >
                                    <option key="0" value="">Select</option>
                                {categories.map((option) => (
                                    <option key={option.id} value={option.id}>
                                        {option.title}
                                    </option>
                                ))}
                                </select>
                                <span className="text-red-600">
                                    {errors.category_id}
                                </span>
                                </div>
                                <div className="mb-4">
                                <label className="block text-gray-700 text-sm font-bold mb-2">
                                    Title
                                </label>
                                <input
                                    className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                    type="text" 
                                    placeholder="Title"
                                    value={data.title}
                                    onChange={(e) =>
                                        setData("title", e.target.value)
                                    }
                                />
                                <span className="text-red-600">
                                    {errors.title}
                                </span>
                                </div>
                                </div>
                                <div className="grid grid-cols-2 gap-4">
                                <div className="mb-4">
                                <label className="block text-gray-700 text-sm font-bold mb-2">
                                    Image
                                </label>
                                <input
                                    className="appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" 
                                
                                    type="file"
                                    placeholder="Image"
                                    name="file"
                                    id="file"
                                    onChange={handleFileChange}
                                />
                                
                                <img src={data.image} width="40px" />
                                <span className="text-red-600">
                                    {errors.file}
                                </span>
                                </div>
                                <div className="mb-4">
                                <label className="block text-gray-700 text-sm font-bold mb-2">
                                    Price
                                </label>
                                <input 
                                className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                    type="text" 
                                    placeholder="Price"
                                    value={data.price}
                                    onChange={(e) =>
                                        setData("price", e.target.value)
                                    }
                                />
                                <span className="text-red-600">
                                    {errors.price}
                                </span>
                                </div>
                                </div>
                                <div className="grid grid-cols-2 gap-4">
                                    <div className="mb-4">
                                    
                                        <label className="block text-gray-700 text-sm font-bold mb-2">
                                            Status
                                        </label>
                                        <select 
                                            onChange={handleStatusChange}
                                            value={data.status}
                                            className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                            id="status" name="status"
                                            >
                                            {status_options.map((option) => (
                                                <option key={option.value} value={option.value}>
                                                    {option.label}
                                                </option>
                                            ))}
                                        </select>

                                        <span className="text-red-600">
                                            {errors.status}
                                        </span>
                                    </div>

                                    <div className="mb-4">
                                        <label className="block text-gray-700 text-sm font-bold mb-2">
                                            Description
                                        </label>
                                        <input 
                                        className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                            
                                            type="text" 
                                            placeholder="Description"
                                            value={data.description}
                                            onChange={(e) =>
                                                setData("description", e.target.value)
                                            }
                                        />
                                        <span className="text-red-600">
                                            {errors.description}
                                        </span>
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-4">
                                
                                    <div className="mb-4">
                                    <label className="block text-gray-700 text-sm font-bold mb-2">
                                        Colors
                                    </label>
                                    <Select
                                    options={colors}
                                    value={data.colors}
                                    className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                    isMulti
                                    onChange={handleColor}
                                    >
                                    </Select>
                                    </div>

                                    <div className="mb-4">
                                    <label className="block text-gray-700 text-sm font-bold mb-2">
                                        Sizes
                                    </label>
                                    <Select
                                    options={sizes}
                                    value={data.sizes}
                                    className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                    isMulti
                                    onChange={handleSize}
                                    >
                                    </Select>
                                    
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-4">
                                    <div className="mb-4">
                                    <label className="block text-gray-700 text-sm font-bold mb-2">
                                        Tags
                                    </label>
                                    <Select
                                    options={tags}
                                    value={data.tags}
                                    className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                    isMulti
                                    onChange={handleTag}
                                    >
                                    </Select>
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-4">
                                <div className="mb-4">
                                <label className="block text-gray-700 text-sm font-bold mb-2">
                                    Features
                                </label>
                                <input 
                                className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                    type="text" 
                                    placeholder="Features"
                                    value={data.features}
                                    onChange={(e) =>
                                        setData("features", e.target.value)
                                    }
                                />
                                <span className="text-red-600">
                                    {errors.features}
                                </span>
                                </div>

                                
                                <div className="mb-4">
                                <label className="block text-gray-700 text-sm font-bold mb-2">
                                    Product Details
                                </label>
                                <input 
                                className="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
                                    type="text" 
                                    placeholder="Product Details"
                                    value={data.product_details}
                                    onChange={(e) =>
                                        setData("product_details", e.target.value)
                                    }
                                />
                                <span className="text-red-600">
                                    {errors.product_details}
                                </span>
                                </div>
                                </div>
                                

                                <div className="flex items-center justify-between">
                                <button className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                    Update
                                </button>
                                </div>
                            </form>
                    
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
