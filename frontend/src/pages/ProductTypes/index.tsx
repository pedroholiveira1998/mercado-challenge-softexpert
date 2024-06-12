import React, { useEffect, useState } from 'react'
import ProductTypesTable from './Components/Table/ProductTypesTable'
import ProductModal from './Components/Modal/ProductTypeModal'
import DeleteModal from '@components/Modals/DeleteModal'
import api from '@lib/api'
import { Backdrop, CircularProgress } from '@mui/material'
import { toast } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'

const ProductTypesPage = () => {
  const [productTypes, setProductTypes] = useState([])
  const [isLoading, setIsLoading] = useState(false)
  const [isCreateModalOpen, setCreateModalOpen] = useState(false)
  const [isEditModalOpen, setEditModalOpen] = useState(false)
  const [isDeleteModalOpen, setDeleteModalOpen] = useState(false)
  const [selectedProduct, setSelectedProduct] = useState(null)

  const fetchProductTypes = async () => {
    setIsLoading(true)
    try {
      const response = await api.get('/api/productType')
      setProductTypes(response.data)
    } catch (error) {
      toast.error('Erro ao buscar dados.')
      console.error('Error fetching data:', error)
    } finally {
      setIsLoading(false)
    }
  }

  useEffect(() => {
    fetchProductTypes()
  }, [])

  const handleOpenCreateModal = () => setCreateModalOpen(true)
  const handleCloseCreateModal = () => setCreateModalOpen(false)

  const handleOpenEditModal = (product) => {
    setSelectedProduct(product)
    setEditModalOpen(true)
  }
  const handleCloseEditModal = () => {
    setSelectedProduct(null)
    setEditModalOpen(false)
  }

  const handleOpenDeleteModal = (product) => {
    setSelectedProduct(product)
    setDeleteModalOpen(true)
  }
  const handleCloseDeleteModal = () => {
    setSelectedProduct(null)
    setDeleteModalOpen(false)
  }

  const handleCreateProduct = async (formData) => {
    setIsLoading(true)
    try {
      await api.post('/api/productType/store', formData)
      handleCloseCreateModal()
      toast.success('Tipo de produto criado com sucesso!')
      await fetchProductTypes()
    } catch (error) {
      toast.error('Erro ao criar produto.')
      console.error('Error creating product:', error)
    } finally {
      setIsLoading(false)
    }
  }

  const handleEditProduct = async (formData) => {
    setIsLoading(true)
    try {
      await api.put(`/api/productType/update/${selectedProduct.id}`, formData)
      handleCloseEditModal()
      toast.success('Tipo de produto editado com sucesso!')
      await fetchProductTypes()
    } catch (error) {
      toast.error('Erro ao editar produto.')
      console.error('Error editing product:', error)
    } finally {
      setIsLoading(false)
    }
  }

  const handleDeleteProduct = async () => {
    setIsLoading(true)
    try {
      await api.delete(`/api/productType/delete/${selectedProduct.id}`)
      handleCloseDeleteModal()
      toast.success('Tipo de produto excluído com sucesso!')
      await fetchProductTypes()
    } catch (error) {
      toast.error('Erro ao excluir produto.')
      console.error('Error deleting product:', error)
    } finally {
      setIsLoading(false)
    }
  }

  return (
    <div>
      <ProductTypesTable
        productTypes={productTypes}
        onCreate={handleOpenCreateModal}
        onEdit={handleOpenEditModal}
        onDelete={handleOpenDeleteModal}
      />
      <ProductModal
        open={isCreateModalOpen}
        onClose={handleCloseCreateModal}
        onSubmit={handleCreateProduct}
      />
      <ProductModal
        open={isEditModalOpen}
        onClose={handleCloseEditModal}
        onSubmit={handleEditProduct}
        product={selectedProduct}
      />
      <DeleteModal
        open={isDeleteModalOpen}
        onClose={handleCloseDeleteModal}
        onDelete={handleDeleteProduct}
      />
      <Backdrop
        sx={{ color: '#fff', zIndex: (theme) => theme.zIndex.drawer + 1 }}
        open={isLoading}
      >
        <CircularProgress color="inherit" />
      </Backdrop>
    </div>
  )
}

export default ProductTypesPage
