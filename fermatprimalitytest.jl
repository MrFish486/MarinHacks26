import Random
function probablyprime(n::BigInt, itr)
	isprime = true
	Threads.@threads for i in 1:itr
		isprime = isprime && ((powermod(rand(1:(n-1)),n-1,n)) == 1)
	end
	return isprime
end

function probablyprimenonparalell(n::BigInt, itr)
	isprime = true
	for i in 1:itr
		isprime = isprime && ((powermod(rand(1:(n-1)),n-1,n)) == 1)
	end
	return isprime
end

function miller_rabin(n, a)
    d = n - 1
    k = 0
    while iseven(d)
        d ÷= 2
        k += 1
    end

    p = powermod(a, d, n)
    if p == 1 || p == n - 1
        return true
    end

    for _ in 1:(k - 1)
        p = powermod(p, 2, n)
        if p == n - 1
            return true
        end
    end

    return false
end

function MR_probablyprime(n, itr = 10)
	# basic trial division
	for num in [2,3,5,7,11,13,17,19,23,29,31,37,41,43,47,53,59,61,67,71,73,79,83,89,97,101,103,107,109,113,127,131,137,139,149,151,157,163,167,173,179,181,191,193,197,199,211,223,227,229,233,239,241,251,257,263,269,271]
		if n == num
			return true
		elseif n % num == 0
			return false
		end
	end

	ip = true
	for i in itr
		ip = ip && miller_rabin(n, rand(2:(n-2)))
	end
	return ip
end

function genprime(digits, itr, lim)
	println("Generating Prime: \n")
	for i in 1:lim
		println("\e[A  $i numbers tested")
		p = rand((big(10)^digits):(big(10)^(digits+1)))
		if probablyprime(p, itr)
			return p,i
		end
	end
end

function genprimeparallel(digits, itr, lim)
	println("Generating Prime: \n")
	outp, outi = 0,0
	t::Float64 = time_ns()/1000000000
	found = false
	Threads.@threads :greedy for i in 1:lim
		if found
			break
		end
		println("\e[A  $i numbers tested, $(round(i/((time_ns()/1000000000)-t), digits=3)::Float64) tests per second")
		p = rand((big(10)^digits):(big(10)^(digits+1)))
		if probablyprimenonparalell(p, itr)
			outp = p
			outi = i
			found = true
		end
	end
	return outp, outi
end

function MRgenprimeparallel(range, doprogressbar = true, itr = 20, lim = 1000000000)
	if doprogressbar
		println("Generating Prime: \n")
	end
	outp, outi = 0,0
	t::Float64 = time_ns()/1000000000
	found = false
	Threads.@threads :greedy for i in 1:lim
		if found
			break
		end
		if doprogressbar
			println("\e[A  $i numbers tested, $(round(i/((time_ns()/1000000000)-t), digits=3)::Float64) tests per second")
		end
		p = rand(Random.RandomDevice(),range)
		if MR_probablyprime(p, itr)
			outp = p
			outi = i
			found = true
		end
	end
	return outp, outi
end

function RSAkeygen(bits::Int64,doloading::Bool=false)
	plen = BigInt(floor(bits/2))
	qlen = BigInt(floor(bits/2))
	goodnfound = false
	n = 0
	while !goodnfound
		p = MRgenprimeparallel(2^(plen):2^(plen+1), doloading)[1]
		q = MRgenprimeparallel(2^(qlen):2^(qlen+1), doloading)[1]
		n = p*q
		goodnfound = abs(p-q) > 2n^0.25
	end
	toilet = lcm(p-1,q-1)
	p = nothing # destroy the evidence
	q = nothing
	e = 0
	for i in 3:2:toilet
		if gcd(i,toilet) == 1
			e = i
			break
		end
	end
	d = invmod(e,toilet)
	toilet = nothing # dont just leave ts sitting around in memory
	public = [n,e]
	private = [n,d]
	return public, private
end

function string2bytes(s::String) 
	return Vector{UInt8}(codeunits(s))
end

function bytes2string(b::Vector{UInt8})
	return String(b)
end

function bytes2bigint(bytes::Vector{UInt8})
    b = BigInt(0)
    for byte in bytes
        b = (b << 8) | BigInt(byte)  # Shift left and add the byte
    end
    return b
end

function bigint2bytes(b::BigInt)
    bytes = UInt8[]
    while b > 0
        pushfirst!(bytes, UInt8(b & 0xff)) # Extract last 8 bits
        b >>= 8 # Shift right
    end
    return bytes
end

function RSAencrypt(key::Vector{BigInt}, data::String, maxchunklen::Int = 16384)
	keylen = Int(floor(log2(key[1])))
	bytesperchunk = min(Int(div(keylen, 8, RoundDown)) - 1,maxchunklen)
	data2encrypt = Vector{BigInt}()
	databin = string2bytes(data)
	for i in 1:bytesperchunk:length(databin)
		bignum = bytes2bigint(databin[i:min(i+bytesperchunk,length(databin))])
		push!(data2encrypt,bignum)
	end
	return [powermod(chunk, key[2], key[1]) for chunk in data2encrypt]
end

function RSAdecrypt(key::Vector{BigInt}, data::Vector{BigInt})
	return join([String(bigint2bytes(powermod(chunk,key[2],key[1]))) for chunk in data])
end
#RSAkeygen(64,false)
#@time k_pub, k_priv = RSAkeygen(4096,true)
#println(k_pub)
#println(k_priv)
#encrypted = RSAencrypt(k_pub,"Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos. Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos. Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.")
n = 8192
println(MR_probablyprime(big(21398712984912487),25))
# while true

# 	x = (MRgenprimeparallel(big(2)^(n - 1):big(2)^n, true, 32, 1000000))
# 	println(x)
# 	f = open("biggestprime.txt","a")
# 	write(f,"\n\n$(x[1])\n\n")
# 	close(f)
# end






















