export interface Product {
    id: number;
    name: string;
    description: string | null;
    price: number;
    image?: string | null;
    created_at: string;
    updated_at: string;
}