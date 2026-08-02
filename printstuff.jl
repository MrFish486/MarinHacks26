include("verification.jl")
println(bytes2bigint(read("public.key")),",",bytes2bigint(read("n.key")),)