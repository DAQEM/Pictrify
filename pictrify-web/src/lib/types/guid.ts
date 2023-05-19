export class Guid {
    public static readonly EMPTY_GUID: Guid = new Guid('00000000-0000-0000-0000-000000000000');
    private static readonly EMPTY_GUID_STRING: string = '00000000-0000-0000-0000-000000000000';
  
    private value: string;
  
    constructor(guid: string = Guid.EMPTY_GUID_STRING) {
      if (!this.isValid(guid)) {
        throw new Error('Invalid GUID format');
      }
      this.value = guid;
    }
  
    static newGuid(): Guid {
      const s4 = (): string =>
        Math.floor((1 + Math.random()) * 0x10000)
          .toString(16)
          .substring(1);
      return new Guid(
        `${s4()}${s4()}-${s4()}-${s4()}-${s4()}-${s4()}${s4()}${s4()}`,
      );
    }
  
    private isValid(guid: string): boolean {
      const regex = /^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/;
      return regex.test(guid);
    }
  
    toString(): string {
      return this.value;
    }
  }