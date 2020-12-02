import requests
import struct

headers = {
    'User-Agent': 'Mozilla/3.0 (compatible; Indy Library)'
}
meta = requests.get('http://update.cz88.net/ip/copywrite.rar', headers=headers)
assert len(meta.content)==280, '元数据长度不正确'
print(meta.content)
print(meta.content.hex())

keys = ['sign', 'date', 'version', 'size', 'unknown', 'key', 'text', 'link']
values = struct.unpack('<4sLLLLL128s128s', meta.content)
meta = dict(zip(keys, values))
meta['sign'] = meta['sign'].decode('gbk')
meta['text'] = meta['text'].decode('gbk').rstrip('\0')
meta['link'] = meta['link'].decode('gbk').rstrip('\0')

assert meta['sign']=='CZIP', '元数据签名不正确'
print(meta)

# data = requests.get('http://update.cz88.net/ip/qqwry.rar', headers=headers)
# print(len(data.content))
